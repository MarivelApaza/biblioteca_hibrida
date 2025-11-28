<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Visor de Libro</title>

    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>

<body>

    <!-- El PDF ya es servido por la ruta alumno.accesos.pdf -->
<iframe 
    src="{{ $urlPDF }}"
    style="width:100%; height:100%; border:none;"
    sandbox="allow-same-origin allow-scripts">
</iframe>


</body>
</html>

