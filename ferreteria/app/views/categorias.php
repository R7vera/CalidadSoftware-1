<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modulo Categorias</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body class="bg-gray-100">

    <!-- Contenedor Principal -->
    <div class="flex min-h-screen">

        <!-- Menú Lateral -->
        <aside class="w-64 bg-gray-900 text-white">
            <div class="p-6 flex flex-col items-center">
                <!-- Foto de Usuario -->
                <?php if (isset($userphoto)): ?>
                    <img class="w-16 h-16 rounded-full mb-4" src="http://localhost/workspace/ferreteria/app/<?php echo htmlspecialchars($userphoto); ?>" alt="<?php echo htmlspecialchars($userphoto); ?>" width="50">
                <?php else: ?>
                    <img src="http://localhost/workspace/ferreteria/app/img/user_defecto.png" alt="Imagen no disponible" width="50">
                <?php endif; ?>
                <!-- Nombre y Rol del Usuario -->
                <h4 class="font-bold text-lg"><?php echo htmlspecialchars($username); ?></h4>
                <p class="text-gray-400"><?php echo htmlspecialchars($rolname); ?></p>
            </div>




            <!-- Menú de Navegación -->
            <nav class="mt-10">
                <a href="dashboard" class="flex items-center py-2.5 px-4 text-gray-200 rounded hover:bg-gray-700 <?php echo $currentPage == 'dashboard' ? 'bg-gray-menu' : ''; ?>">
                    <span class="mr-2">
                        <!-- Icono Dashboard -->
                        <i class="fas fa-tachometer-alt"></i>
                    </span>
                    Dashboard
                </a>
                <a href="clientes" class="flex items-center py-2.5 px-4 text-gray-200 rounded hover:bg-gray-700 <?php echo $currentPage == 'clientes' ? 'bg-gray-menu' : ''; ?>">
                    <span class="mr-2">
                        <!-- Icono Cliente -->
                        <i class="fas fa-user"></i>
                    </span>
                    Cliente
                </a>
                <a href="proveedores" class="flex items-center py-2.5 px-4 text-gray-200 rounded hover:bg-gray-700 <?php echo $currentPage == 'proveedores.php' ? 'bg-gray-menu' : ''; ?>">
                    <span class="mr-2">
                        <!-- Icono Proveedor -->
                        <i class="fas fa-truck"></i>
                    </span>
                    Proveedor
                </a>
                <a href="categorias" class="flex items-center py-2.5 px-4 text-gray-200 rounded hover:bg-gray-700 <?php echo $currentPage == 'categorias.php' ? 'bg-gray-menu' : ''; ?>">
                    <span class="mr-2">
                        <!-- Icono Categoría -->
                        <i class="fas fa-tags"></i>
                    </span>
                    Categoría
                </a>
                <a href="productos" class="flex items-center py-2.5 px-4 text-gray-200 rounded hover:bg-gray-700 <?php echo $currentPage == 'productos.php' ? 'bg-gray-900' : ''; ?>">
                    <span class="mr-2">
                        <!-- Icono Producto -->
                        <i class="fas fa-boxes"></i>
                    </span>
                    Productos
                </a>
                <a href="ventas" class="flex items-center py-2.5 px-4 text-gray-200 rounded hover:bg-gray-700 <?php echo $currentPage == 'ventas.php' ? 'bg-gray-900' : ''; ?>">
                    <span class="mr-2">
                        <!-- Icono Ventas -->
                        <i class="fas fa-shopping-cart"></i>
                    </span>
                    Ventas
                </a>
            </nav>
        </aside>

        <!-- Contenido del Dashboard -->
        <div class="flex-1 p-8">
            <header class="flex items-center justify-between mb-8">
                <!-- Barra de Búsqueda -->
                <div class="flex items-center bg-white rounded-lg shadow p-3 w-1/2">
                    <input type="text" placeholder="Type to search..." class="bg-transparent focus:outline-none flex-grow">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 14s6-6 8-6M9 11h3v3" />
                    </svg>
                </div>

                <!-- Botón de Cerrar Sesión -->
                <div>
                    <a href="logout" class="flex items-center bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none">
                        <!-- SVG de una X -->
                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cerrar Sesión
                    </a>
                </div>
            </header>


            <!-- Tabla de Clientes -->
            <div class="mt-8 bg-white p-6 rounded-lg shadow">
                <!-- Contenedor del título y el botón en la misma fila -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold">Lista de Categorias</h2>
                    <button id="openModal" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Registrar Categoria
                    </button>
                </div>

                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2">#</th>
                            <th class="border border-gray-300 px-4 py-2">Categoria</th>
                            <th class="border border-gray-300 px-4 py-2">Fecha Registro </th>
                            <th class="border border-gray-300 px-4 py-2">Estado</th>
                            <th class="border border-gray-300 px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categories)): ?>
                            <?php $index = 1; ?>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo $index++; ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($category['categoria_nombre']); ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($category['categoria_fregistro']); ?></td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <?php if ($category['categoria_estatus'] == 'ACTIVO'): ?>
                                            <span class="text-green-500 font-bold"><?php echo htmlspecialchars($category['categoria_estatus']); ?></span>
                                        <?php else: ?>
                                            <span class="text-red-500 font-bold"><?php echo htmlspecialchars($category['categoria_estatus']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <a href="categorias?id=<?php echo htmlspecialchars($category['categoria_id']); ?>&action=ACTIVO" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="categorias?id=<?php echo htmlspecialchars($category['categoria_id']); ?>&action=INACTIVO" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="border border-gray-300 px-4 py-2 text-center">No hay categoris registradas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Ventana Modal -->
            <div id="myModal" class="modal hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-1/2 relative"> <!-- Ancho ajustado a la mitad de la pantalla -->
                    <!-- Título con botón de cerrar -->
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold">Registrar Categoria</h2>
                        <button id="closeModal" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <!-- Formulario de registro -->
                    <form id="categoryForm" action="categorias" method="POST">
                        <!-- Nombre -->
                        <div class="mb-4">
                            <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="Ingrese nombre" required>
                        </div>
                        <!-- Botón de Registrar -->
                        <div class="flex justify-center">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Registrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                const openModalBtn = document.getElementById('openModal');
                const closeModalBtn = document.getElementById('closeModal');
                const modal = document.getElementById('myModal');
                const clienteForm = document.getElementById('clienteForm');

                function resetForm() {
                    clienteForm.reset();
                }


                openModalBtn?.addEventListener('click', function() {
                    modal.classList.remove('hidden');
                });
                closeModalBtn?.addEventListener('click', function() {
                    modal.classList.add('hidden');
                    resetForm();
                });

                window.addEventListener('click', function(event) {
                    if (event.target === modal) {
                        modal.classList.add('hidden');
                        resetForm();
                    }
                });
            </script>

            <style>
                .modal.hidden {
                    display: none;
                }

                .modal {
                    display: flex;
                }
            </style>


        </div>
    </div>

</body>

</html>