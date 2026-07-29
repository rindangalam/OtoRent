@props([
    'color1' => '0.118, 0.227, 0.373',
    'color2' => '0.043, 0.114, 0.231',
    'accent' => '0.961, 0.620, 0.043',
    'speed' => '0.4',
])

<canvas class="w-full h-full" id="hero-shader-{{ md5($color1.$color2.$accent.$speed) }}"></canvas>

<script>
(function() {
    const canvas = document.getElementById('hero-shader-{{ md5($color1.$color2.$accent.$speed) }}');
    if (!canvas) return;

    function syncSize() {
        const w = canvas.clientWidth || 1280;
        const h = canvas.clientHeight || 720;
        if (canvas.width !== w || canvas.height !== h) {
            canvas.width = w;
            canvas.height = h;
        }
    }
    if (typeof ResizeObserver !== 'undefined') {
        new ResizeObserver(syncSize).observe(canvas);
    }
    syncSize();

    const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
    if (!gl) return;

    const vertexShaderSrc = `
        attribute vec2 a_position;
        varying vec2 v_texCoord;
        void main() {
            v_texCoord = a_position * 0.5 + 0.5;
            gl_Position = vec4(a_position, 0.0, 1.0);
        }
    `;

    const fragmentShaderSrc = `
        precision highp float;
        uniform float u_time;
        uniform vec2 u_resolution;
        uniform vec2 u_mouse;
        varying vec2 v_texCoord;
        void main() {
            vec2 uv = v_texCoord;
            float time = u_time * {{ $speed }};
            vec2 p = -1.0 + 2.0 * uv;
            p.x *= u_resolution.x / u_resolution.y;
            float wave = sin(p.x * 2.0 + time) * cos(p.y * 2.0 + time * 0.5);
            wave += sin(p.y * 3.0 - time * 0.8) * cos(p.x * 1.5 + time * 0.3);
            vec2 mouse = u_mouse / u_resolution;
            wave += sin((p.x + mouse.x) * 2.5 + time * 0.6) * cos((p.y + mouse.y) * 2.5 + time * 0.4) * 0.3;
            vec3 color1 = vec3({{ $color1 }});
            vec3 color2 = vec3({{ $color2 }});
            vec3 accent = vec3({{ $accent }});
            float mixFactor = clamp(wave * 0.5 + 0.5, 0.0, 1.0);
            vec3 finalColor = mix(color1, color2, mixFactor);
            float highlight = pow(mixFactor, 10.0) * 0.15;
            finalColor += accent * highlight;
            gl_FragColor = vec4(finalColor, 1.0);
        }
    `;

    function createShader(gl, type, source) {
        const shader = gl.createShader(type);
        gl.shaderSource(shader, source);
        gl.compileShader(shader);
        return shader;
    }

    const program = gl.createProgram();
    gl.attachShader(program, createShader(gl, gl.VERTEX_SHADER, vertexShaderSrc));
    gl.attachShader(program, createShader(gl, gl.FRAGMENT_SHADER, fragmentShaderSrc));
    gl.linkProgram(program);
    gl.useProgram(program);

    const positionBuffer = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, positionBuffer);
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1, -1, 1, -1, -1, 1, 1, 1]), gl.STATIC_DRAW);

    const positionLocation = gl.getAttribLocation(program, 'a_position');
    gl.enableVertexAttribArray(positionLocation);
    gl.vertexAttribPointer(positionLocation, 2, gl.FLOAT, false, 0, 0);

    const timeLoc = gl.getUniformLocation(program, 'u_time');
    const resLoc = gl.getUniformLocation(program, 'u_resolution');
    const mouseLoc = gl.getUniformLocation(program, 'u_mouse');

    let mouse = { x: canvas.width / 2, y: canvas.height / 2 };
    window.addEventListener('mousemove', function(event) {
        var rect = canvas.getBoundingClientRect();
        if (rect.width && rect.height) {
            var nx = (event.clientX - rect.left) / rect.width;
            var ny = 1.0 - (event.clientY - rect.top) / rect.height;
            mouse.x = nx * canvas.width;
            mouse.y = ny * canvas.height;
        }
    });

    function render(time) {
        if (typeof ResizeObserver === 'undefined') syncSize();
        gl.viewport(0, 0, canvas.width, canvas.height);
        gl.uniform1f(timeLoc, time * 0.001);
        gl.uniform2f(resLoc, canvas.width, canvas.height);
        if (mouseLoc) gl.uniform2f(mouseLoc, mouse.x, mouse.y);
        gl.drawArrays(gl.TRIANGLE_STRIP, 0, 4);
        requestAnimationFrame(render);
    }
    requestAnimationFrame(render);
})();
</script>
