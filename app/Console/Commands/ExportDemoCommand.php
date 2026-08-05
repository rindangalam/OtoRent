<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Driver;
use App\Models\Jadwal;
use App\Models\Kendaraan;
use App\Models\Pembayaran;
use App\Models\ServiceKendaraan;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Process\InvokedProcess;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process as ProcessFacade;

class ExportDemoCommand extends Command
{
    protected $signature = 'demo:export
        {--port=8765 : Port untuk server lokal sementara}
        {--output=demo-static : Folder hasil export}';

    protected $description = 'Render seluruh halaman demo menjadi HTML statis (untuk deploy Vercel dll.)';

    private const ROLES = ['admin', 'staff', 'customer'];

    private array $queryPages = [
        '/kendaraan?jenis=' => 'kendaraan/jenis-semua',
        '/kendaraan?jenis=mpv' => 'kendaraan/jenis-mpv',
        '/kendaraan?jenis=suv' => 'kendaraan/jenis-suv',
        '/kendaraan?jenis=sedan' => 'kendaraan/jenis-sedan',
        '/kendaraan?jenis=minibus' => 'kendaraan/jenis-minibus',
        '/kendaraan?jenis=truk' => 'kendaraan/jenis-truk',
        '/kendaraan?sort=harga_terendah' => 'kendaraan/sort-harga-terendah',
        '/kendaraan?sort=harga_tertinggi' => 'kendaraan/sort-harga-tertinggi',
    ];

    public function handle(): int
    {
        $port = (int) $this->option('port');
        $output = base_path($this->option('output'));

        $this->ensureDemoDatabase();

        $server = $this->startServer($port);

        try {
            $this->crawl($port, $output);
        } finally {
            $server->stop();
        }

        $this->info("Export selesai: {$output}");

        return self::SUCCESS;
    }

    private function ensureDemoDatabase(): void
    {
        $db = storage_path('demo/demo.sqlite');

        if (File::exists($db)) {
            return;
        }

        $this->info('Menyiapkan database demo (migrate + seed)...');
        File::ensureDirectoryExists(storage_path('demo'));
        Artisan::call('migrate', ['--force' => true]);
        Artisan::call('db:seed', ['--force' => true]);
    }

    private function startServer(int $port): InvokedProcess
    {
        $base = "http://127.0.0.1:{$port}";
        $this->info("Menjalankan server demo sementara: {$base}");

        $process = ProcessFacade::start(
            [PHP_BINARY, 'artisan', 'serve', '--host=127.0.0.1', "--port={$port}"],
            null,
            ['APP_URL' => $base, 'APP_DEMO' => 'true']
        );

        $ready = false;
        for ($i = 0; $i < 60; $i++) {
            if (! $process->running()) {
                throw new \RuntimeException('Server gagal dijalankan: '.$process->errorOutput());
            }
            try {
                if (Http::timeout(2)->get("{$base}/up")->status() === 200) {
                    $ready = true;
                    break;
                }
            } catch (\Throwable) {
                // server belum siap
            }
            usleep(500000);
        }

        if (! $ready) {
            $process->stop();
            throw new \RuntimeException('Server tidak siap dalam 30 detik.');
        }

        $this->info('Server siap.');

        return $process;
    }

    private function crawl(int $port, string $output): void
    {
        $base = "http://127.0.0.1:{$port}";
        $pages = $this->buildPageList();

        $guestClient = new Client([
            'base_uri' => "{$base}/",
            'cookies' => true,
            'allow_redirects' => ['max' => 10],
            'http_errors' => false,
            'timeout' => 30,
        ]);

        $this->info('Meng-crawl halaman publik...');
        foreach (array_merge($pages['guest'], array_keys($this->queryPages)) as $path) {
            $this->fetchAndSave($guestClient, $base, $path, $output);
        }

        foreach (self::ROLES as $role) {
            $this->info("Login sebagai {$role}...");
            $client = $this->loginAs($base, $role);
            $check = $role === 'customer' ? '/dashboard' : '/admin';

            if ($client->get($check)->getStatusCode() !== 200) {
                $this->warn("Login sebagai {$role} gagal — halaman {$check} tidak bisa diakses.");
                continue;
            }

            foreach ($pages[$role] as $path) {
                $this->fetchAndSave($client, $base, $path, $output);
            }
        }

        $this->copyAssets($output);
        $this->writeVercelConfig($output);
    }

    private function buildPageList(): array
    {
        $kendaraan = Kendaraan::pluck('id');
        $drivers = Driver::pluck('id');
        $jadwals = Jadwal::pluck('id');
        $bookings = Booking::pluck('id');
        $pembayarans = Pembayaran::pluck('id');
        $services = ServiceKendaraan::pluck('id');

        $andiId = User::where('email', 'andi@example.com')->value('id');
        $customerBookings = Booking::where('user_id', $andiId)->pluck('id');

        $ids = fn ($collection, string $prefix): array => $collection->map(fn ($id) => "{$prefix}/{$id}")->all();
        $edits = fn ($collection, string $prefix): array => $collection->map(fn ($id) => "{$prefix}/{$id}/edit")->all();

        $guestPages = array_merge([
            '/', '/layanan', '/kontak', '/kendaraan', '/login', '/register', '/demo',
        ], $ids($kendaraan, '/kendaraan'));

        $adminPages = array_merge([
            '/admin', '/profile',
            '/admin/kendaraan', '/admin/kendaraan/create',
            '/admin/driver', '/admin/driver/create',
            '/admin/jadwal', '/admin/jadwal/create',
            '/admin/booking',
            '/admin/pembayaran',
            '/admin/service', '/admin/service/create',
            '/admin/laporan',
        ],
            $edits($kendaraan, '/admin/kendaraan'),
            $edits($drivers, '/admin/driver'),
            $edits($jadwals, '/admin/jadwal'),
            $ids($bookings, '/admin/booking'),
            $ids($pembayarans, '/admin/pembayaran'),
            $edits($services, '/admin/service'),
        );

        return [
            'guest' => $guestPages,
            'admin' => $adminPages,
            'staff' => $adminPages,
            'customer' => array_merge([
                '/dashboard', '/booking', '/booking/create', '/profil', '/profile',
            ],
                $ids($customerBookings, '/booking'),
                $customerBookings->map(fn ($id) => "/booking/{$id}/bayar")->all(),
            ),
        ];
    }

    private function loginAs(string $base, string $role): Client
    {
        $client = new Client([
            'base_uri' => "{$base}/",
            'cookies' => true,
            'allow_redirects' => ['max' => 10],
            'http_errors' => false,
            'timeout' => 30,
        ]);

        $loginPage = $client->get('/login');
        preg_match('/name="_token" value="([^"]+)"/', (string) $loginPage->getBody(), $m);
        $token = $m[1] ?? '';

        if ($token === '') {
            throw new \RuntimeException('CSRF token tidak ditemukan di halaman login.');
        }

        $client->post("/demo/login/{$role}", [
            'form_params' => ['_token' => $token],
        ]);

        return $client;
    }

    private function fetchAndSave(Client $client, string $base, string $path, string $output): void
    {
        try {
            $response = $client->get($path);
        } catch (\Throwable $e) {
            $this->warn("Gagal: {$path} ({$e->getMessage()})");
            return;
        }

        if ($response->getStatusCode() !== 200) {
            $this->warn("Status {$response->getStatusCode()}: {$path}");
            return;
        }

        $html = $this->rewriteHtml((string) $response->getBody(), $base, $path);

        $file = $this->outputFileFor($path, $output);
        File::ensureDirectoryExists(dirname($file));
        File::put($file, $html);

        $this->line("  OK  {$path}");
    }

    private function outputFileFor(string $path, string $output): string
    {
        if (array_key_exists($path, $this->queryPages)) {
            return $output.'/'.$this->queryPages[$path].'/index.html';
        }

        $path = trim(parse_url($path, PHP_URL_PATH), '/');

        return $path === ''
            ? $output.'/index.html'
            : $output.'/'.$path.'/index.html';
    }

    private function rewriteHtml(string $html, string $base, string $path = ''): string
    {
        $html = str_replace($base, '', $html);

        foreach ($this->queryPages as $url => $staticPath) {
            $html = str_replace('href="'.$url.'"', 'href="/'.$staticPath.'/"', $html);
        }

        $html = preg_replace_callback(
            '/((?:href|action)=")(\/)([^"]*?)(\")/',
            function (array $m): string {
                $path = $m[3];

                if ($path === '' || str_contains($path, '#') || str_contains($path, '?') || str_ends_with($path, '/')) {
                    return $m[0];
                }

                if (pathinfo($path, PATHINFO_EXTENSION) !== '') {
                    return $m[0];
                }

                return $m[1].$m[2].$path.'/'.$m[4];
            },
            $html
        );

        // Pada halaman login statis, tombol quick-login tidak bisa POST.
        // Ganti form menjadi link langsung ke dashboard per role.
        if ($path === '/login') {
            $html = $this->replaceDemoLoginForms($html);
        }

        return $html;
    }

    private function replaceDemoLoginForms(string $html): string
    {
        $roles = [
            'admin' => ['/admin/', 'Admin', 'bg-primary text-on-primary hover:bg-primary-container'],
            'staff' => ['/admin/', 'Staff', 'bg-tertiary text-on-tertiary hover:bg-tertiary-container'],
            'customer' => ['/dashboard/', 'Customer', 'bg-secondary-container text-on-secondary-container hover:shadow-md'],
        ];

        return preg_replace_callback(
            '/<form method="POST" action="\/demo\/login\/(admin|staff|customer)\/"\s*>.*?<\/form>/s',
            function (array $m) use ($roles): string {
                [$href, $label, $classes] = $roles[$m[1]];

                return '<a href="'.$href.'" class="w-full block text-center py-2.5 px-3 rounded-lg '.$classes.' font-bold text-xs transition-all">'.$label.'</a>';
            },
            $html
        );
    }

    private function copyAssets(string $output): void
    {
        $this->info('Menyalin aset statis (CSS/JS & gambar)...');

        if (is_dir(public_path('build'))) {
            File::copyDirectory(public_path('build'), $output.'/build');
        }

        if (is_dir(storage_path('app/public'))) {
            File::copyDirectory(storage_path('app/public'), $output.'/storage');
        }

        foreach (glob(public_path('*')) as $file) {
            $name = basename($file);
            if (in_array($name, ['build', 'storage', 'index.php', '.htaccess'])) {
                continue;
            }
            if (is_file($file)) {
                File::copy($file, $output.'/'.$name);
            }
        }
    }

    private function writeVercelConfig(string $output): void
    {
        File::put($output.'/vercel.json', json_encode([
            'cleanUrls' => false,
            'trailingSlash' => true,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
