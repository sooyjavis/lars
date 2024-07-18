<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Javooo">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directorio</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }

        main {
            width: 100%;
            max-width: 800px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .search-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            margin-bottom: 0;
        }

        select,
        input[type="text"] {
            width: 100%;
            padding: 8px;
            font-size: 1rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            background-color: #fff;
            border-collapse: collapse;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        th,
        td {
            text-align: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #343a40;
            color: #fff;
        }

    </style>
</head>

<body>
    <main class="container">
        <h2>Directorio de usuarios</h2>

        <div class="search-row">
            <div class="form-group col-sm-6 col-md-4">
                <label for="num_registros">Mostrar:</label>
                <select name="num_registros" id="num_registros" class="form-control">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="125">125</option>
                    <option value="150">150</option>
                </select>
            </div>

            <div class="form-group col-sm-6 col-md-4">
                <label for="campo">Buscar:</label>
                <input type="text" name="campo" id="campo" class="form-control">
            </div>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th class="sort asc" data-column="0">Id</th>
                    <th class="sort asc" data-column="1">Nombre</th>
                    <th class="sort asc" data-column="2">Apellido</th>
                    <th class="sort asc" data-column="5">Escuela</th>
                    <th class="sort asc" data-column="3">Turno</th>
                    <th class="sort asc" data-column="4">Email</th>
                    <th class="sort asc" data-column="6">Password</th>
                    <th class="sort asc" data-column="7">Password Decifrada</th>
                </tr>
            </thead>
            <tbody id="content"></tbody>
        </table>

        <div class="row">
            <div class="col-md-6">
                <p id="lbl-total" class="text-muted"></p>
            </div>

            <div class="col-md-6" id="nav-paginacion"></div>

            <input type="hidden" id="pagina" value="1">
            <input type="hidden" id="orderCol" value="0">
            <input type="hidden" id="orderType" value="asc">
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", getData);

        function getData() {
            let input = document.getElementById("campo").value;
            let num_registros = document.getElementById("num_registros").value;
            let content = document.getElementById("content");
            let pagina = document.getElementById("pagina").value || 1;
            let orderCol = document.getElementById("orderCol").value;
            let orderType = document.getElementById("orderType").value;

            let formData = new FormData();
            formData.append('campo', input);
            formData.append('registros', num_registros);
            formData.append('pagina', pagina);
            formData.append('orderCol', orderCol);
            formData.append('orderType', orderType);

            fetch("load.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data && data.data) {
                        content.innerHTML = data.data;
                        let totalFiltrado = parseInt(data.totalFiltro);
                        let totalRegistros = parseInt(data.totalRegistros);
                        let desde = (pagina - 1) * num_registros + 1;
                        let hasta = Math.min(pagina * num_registros, totalFiltrado);

                        document.getElementById("lbl-total").textContent = `Mostrando ${desde} - ${hasta} de ${totalFiltrado} registros`;
                        document.getElementById("nav-paginacion").innerHTML = data.paginacion;

                        // Si la página actual no tiene resultados y no es la primera página, ir a la primera página
                        if (data.data.includes('Sin resultados') && parseInt(pagina) !== 1) {
                            nextPage(1);
                        }
                    } else {
                        content.innerHTML = '<tr><td colspan="8">Error al obtener datos</td></tr>';
                    }
                })
                .catch(err => {
                    console.error('Error al obtener datos:', err);
                    content.innerHTML = '<tr><td colspan="8">Error de conexión</td></tr>';
                });
        }

        function nextPage(pagina) {
            document.getElementById('pagina').value = pagina;
            getData();
        }

        function ordenar(e) {
            let elemento = e.target;
            let orderType = elemento.classList.contains("asc") ? "desc" : "asc";

            document.getElementById('orderCol').value = elemento.cellIndex;
            document.getElementById("orderType").value = orderType;
            elemento.classList.toggle("asc");
            elemento.classList.toggle("desc");

            getData();
        }

        document.getElementById("campo").addEventListener("keyup", getData);
        document.getElementById("num_registros").addEventListener("change", () => {
            document.getElementById("pagina").value = 1; // Reiniciar a la primera página al cambiar el número de registros por página
            getData();
        });

        let columns = document.querySelectorAll(".sort");
        columns.forEach(column => {
            column.addEventListener("click", ordenar);
        });
    </script>

</body>

</html>
