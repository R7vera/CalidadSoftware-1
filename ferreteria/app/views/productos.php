<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                    <h2 class="text-lg font-bold">Lista de Productos</h2>
                    <button id="openModal" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Registrar Productos
                    </button>
                </div>

                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2">#</th>
                            <th class="border border-gray-300 px-4 py-2">Producto</th>
                            <th class="border border-gray-300 px-4 py-2">Presentación</th>
                            <th class="border border-gray-300 px-4 py-2">Categoría</th>
                            <th class="border border-gray-300 px-4 py-2">U. Medida</th>
                            <th class="border border-gray-300 px-4 py-2">Stock</th>
                            <th class="border border-gray-300 px-4 py-2">Precio</th>
                            <th class="border border-gray-300 px-4 py-2">Foto</th>
                            <th class="border border-gray-300 px-4 py-2">Estado</th>
                            <th class="border border-gray-300 px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)): ?>
                            <?php $index = 1; ?>
                            <?php foreach ($products as $producto): ?>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo $index++; ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($producto['producto_nombre']); ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($producto['producto_presentacion']); ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($producto['categoria_nombre']); ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($producto['unidad_nombre']); ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($producto['producto_stock']); ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($producto['producto_precioventa']); ?></td>
                                    <td>
                                        <?php if (isset($producto['producto_foto'])): ?>
                                            <img src="http://localhost/workspace/ferreteria/app/img/<?php echo basename(htmlspecialchars($producto['producto_foto'])); ?>" alt="<?php echo htmlspecialchars($producto['producto_nombre']); ?>" width="50">
                                        <?php else: ?>
                                            <img src="/ruta_por_defecto.jpg" alt="Imagen no disponible" width="50">
                                        <?php endif; ?>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <?php if ($producto['producto_estatus'] == 'ACTIVO'): ?>
                                            <span class="text-green-500 font-bold"><?php echo htmlspecialchars($producto['producto_estatus']); ?></span>
                                        <?php else: ?>
                                            <span class="text-red-500 font-bold"><?php echo htmlspecialchars($producto['producto_estatus']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <a href="productos?id=<?php echo htmlspecialchars($producto['producto_id']); ?>&action=ACTIVO" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="productos?id=<?php echo htmlspecialchars($producto['producto_id']); ?>&action=INACTIVO" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="border border-gray-300 px-4 py-2 text-center">No hay clientes registrados.</td>
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
                        <h2 class="text-lg font-bold">Registrar Productos</h2>
                        <button id="closeModal" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <!-- Formulario de registro -->
                    <form id="clienteForm" action="productos" method="POST" enctype="multipart/form-data">


                        <!-- Apellidos (Paterno y Materno en una fila) -->
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label for="producto_nombre" class="block text-gray-700 font-bold mb-2">Producto:</label>
                                <input type="text" id="producto_nombre" name="producto_nombre" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="Ingrese producto" required>
                            </div>
                            <div>
                                <label for="producto_presentacion" class="block text-gray-700 font-bold mb-2">Presentacion:</label>
                                <input type="text" id="producto_presentacion" name="producto_presentacion" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="Ingrese presentacion" required>
                            </div>
                        </div>

                        <!-- Número de Documento y Tipo de Documento (en una fila) -->
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label for="categoria_id" class="block text-gray-700 font-bold mb-2">Categoria:</label>
                                <select id="categoria_id" name="categoria_id" class="w-full px-4 py-2 border border-gray-300 rounded" required>
                                    <option value="">Seleccione</option>
                                    <?php if (!empty($categories)): ?>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category['categoria_id']; ?>"><?php echo htmlspecialchars($category['categoria_nombre']); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div>
                                <label for="unidad_id" class="block text-gray-700 font-bold mb-2">Unidad de medida:</label>
                                <select id="unidad_id" name="unidad_id" class="w-full px-4 py-2 border border-gray-300 rounded" required>
                                    <option value="">Seleccione</option>
                                    <?php if (!empty($unidades)): ?>
                                        <?php foreach ($unidades as $unidad): ?>
                                            <option value="<?php echo $unidad['unidad_id']; ?>"><?php echo htmlspecialchars($unidad['unidad_nombre']); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Subir foto y Precio (en una fila) -->
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label for="producto_imagen" class="block text-gray-700 font-bold mb-2">Subir Foto:</label>
                                <input type="file" id="producto_imagen" name="producto_imagen" accept=".jpg,.jpeg,.png,.gif" class="w-full px-4 py-2 border border-gray-300 rounded" required>
                            </div>
                            <div>
                                <label for="producto_precio" class="block text-gray-700 font-bold mb-2">Precio:</label>
                                <input type="number" id="producto_precio" name="producto_precio" min="0.01" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="$0.00" required>
                            </div>
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