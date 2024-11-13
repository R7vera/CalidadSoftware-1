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

      <?php
      // Obtener el nombre de la página actual
      $currentPage = 'dashboard';

      ?>

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

      <div class="mb-6 bg-white p-4 rounded-lg shadow">
        <form method="POST" class="flex items-center space-x-4">
          <div class="relative w-1/3">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
              </svg>
            </div>
            <input id="datepicker-range-start" name="finicio" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Desde">
          </div>

          <span class="text-gray-500">a</span>

          <div class="relative w-1/3">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
              </svg>
            </div>
            <input id="datepicker-range-end" name="ffin" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Hasta">
          </div>

          <button type="submit" name="filtrar" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filtrar</button>
        </form>

        <?php if (!empty($error)): ?>
          <div class="w-full mt-4">
            <p style="color: red;"><?php echo $error; ?></p>
          </div>
        <?php endif; ?>
      </div>

      <div class="grid grid-cols-3 gap-6">
        <!-- Total de Ventas -->
        <div class="bg-white p-6 rounded-lg shadow">
          <div class="flex items-center justify-between">
            <span class="text-3xl font-bold"><?php echo $total_ventas; ?></span>

          </div>
          <p class="text-gray-500">Total de Ventas</p>
        </div>

        <!-- Total de Ingresos -->
        <div class="bg-white p-6 rounded-lg shadow">
          <div class="flex items-center justify-between">
            <span class="text-3xl font-bold"><?php echo "$" . number_format($total_ingresos, 2); ?></span>

          </div>
          <p class="text-gray-500">Total de Ingresos</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
          <div class="flex items-center justify-between">
            <span class="text-3xl font-bold"><?php echo htmlspecialchars($ventas_realizadas) ?></span>

          </div>
          <p class="text-gray-500">Ventas Realizadas</p>
        </div>

      </div>



      <!-- Tabla de Ventas -->
      <div class="mt-8 bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-4">Últimas Ventas</h2>
        <table class="min-w-full border-collapse border border-gray-300">
          <thead>
            <tr class="bg-gray-200">
              <th class="border border-gray-300 px-4 py-2">ID Venta</th>
              <th class="border border-gray-300 px-4 py-2">Fecha</th>
              <th class="border border-gray-300 px-4 py-2">Total</th>
            </tr>
          </thead>
          <tbody>
            <!--
            <?php foreach ($ventas as $venta): ?>
            <tr>
              <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($venta['id_venta']); ?></td>
              <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($venta['fecha']); ?></td>
              <td class="border border-gray-300 px-4 py-2"><?php echo "$" . number_format($venta['total'], 2); ?></td>
            </tr>
            <?php endforeach; ?> -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <style>
    /* Clase personalizada para el enlace del menú seleccionado */
    .bg-gray-menu {
      background-color: #1a202c;
      /* Fondo más oscuro para la opción seleccionada */
      font-weight: bold;
      /* Negrita para resaltar el texto */
    }
  </style>
</body>

</html>