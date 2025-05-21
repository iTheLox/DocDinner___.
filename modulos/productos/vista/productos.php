<div class="bg-neutral-50 min-h-screen text-neutral-950 p-4 md:p-8">
    <header class="mb-6">
        <h1 class="text-2xl font-bold">Tus Gastos</h1>
    </header>

    <main class="mx-auto space-y-8">
        <div class="rounded-xl bg-white p-6 shadow-lg">
            <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                <div>
                    <label for="categoria" class="block text-sm font-medium">Buscar por Categoría:</label>
                    <select id="categoria" name="categoria" required class="mt-1 block w-full rounded-md bg-gray-100 border border-gray-300 py-2 pl-3 pr-10 focus:border-primary focus:outline-none focus:ring-primary sm:text-sm">
                        <option value="">Seleccione una categoría</option>
                        <option value="Alimentación" <?= $categoriaSeleccionada == 'Alimentación' ? 'selected' : '' ?>>Alimentación</option>
                        <option value="Transporte" <?= $categoriaSeleccionada == 'Transporte' ? 'selected' : '' ?>>Transporte</option>
                        <option value="Vivienda" <?= $categoriaSeleccionada == 'Vivienda' ? 'selected' : '' ?>>Vivienda</option>
                        <option value="Servicios" <?= $categoriaSeleccionada == 'Servicios' ? 'selected' : '' ?>>Servicios</option>
                        <option value="Entretenimiento" <?= $categoriaSeleccionada == 'Entretenimiento' ? 'selected' : '' ?>>Entretenimiento</option>
                        <option value="Salud y belleza" <?= $categoriaSeleccionada == 'Salud y belleza' ? 'selected' : '' ?>>Salud y belleza</option>
                        <option value="Educación" <?= $categoriaSeleccionada == 'Educación' ? 'selected' : '' ?>>Educación</option>
                        <option value="Electrónica" <?= $categoriaSeleccionada == 'Electrónica' ? 'selected' : '' ?>>Electrónica</option>
                        <option value="Ropa y accesorios" <?= $categoriaSeleccionada == 'Ropa y accesorios' ? 'selected' : '' ?>>Ropa y accesorios</option>
                        <option value="Hogar y decoración" <?= $categoriaSeleccionada == 'Hogar y decoración' ? 'selected' : '' ?>>Hogar y decoración</option>
                        <option value="Deportes y aire libre" <?= $categoriaSeleccionada == 'Deportes y aire libre' ? 'selected' : '' ?>>Deportes y aire libre</option>
                        <option value="Juguetes y juegos" <?= $categoriaSeleccionada == 'Juguetes y juegos' ? 'selected' : '' ?>>Juguetes y juegos</option>
                        <option value="Automóviles y accesorios" <?= $categoriaSeleccionada == 'Automóviles y accesorios' ? 'selected' : '' ?>>Automóviles y accesorios</option>
                        <option value="Tecnología y software" <?= $categoriaSeleccionada == 'Tecnología y software' ? 'selected' : '' ?>>Tecnología y software</option>
                        <option value="Otro" <?= $categoriaSeleccionada == 'Otro' ? 'selected' : '' ?>>Otro</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="submit" name="buscar_categoria" class="rounded-md bg-custom-gradient px-4 py-2 text-sm font-semibold text-white shadow-sm hover:opacity-90 transition">Buscar</button>
                    <button type="submit" name="ver_total_categoria" class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 transition">Ver Total de la Categoría</button>
                </div>
            </form>
            <?php if ($total_categoria !== null): ?>
                <div class="mt-4 rounded-md bg-gray-100 p-4">
                    <h2 class="text-lg font-semibold">Total de la categoría "<?= htmlspecialchars($categoriaSeleccionada); ?>": $<?= number_format($total_categoria, 2, ',', '.'); ?></h2>
                </div>
            <?php endif; ?>
        </div>

        <div class="rounded-xl bg-white p-6 shadow-lg">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-xl font-semibold">Lista de Gastos Fijos</h2>
                <div class="flex items-center gap-2">
                    <button data-modal-target="agregar-modal" data-modal-toggle="agregar-modal" class="rounded-md bg-custom-gradient px-3 py-2 text-sm font-semibold text-white shadow-sm hover:opacity-90 transition">Añadir Gasto</button>
                    <form method="POST">
                        <button type="submit" name="ver_total" class="rounded-md bg-custom-gradient px-4 py-2 text-sm font-semibold text-white shadow-sm hover:opacity-90 transition">Ver Total de Gastos</button>
                    </form>
                </div>
            </div>
            <?php if ($total_gastos !== null): ?>
                <div class="mt-4 rounded-md bg-gray-100 p-4">
                    <h2 class="text-lg font-semibold">Total de gastos realizados: $<?= number_format($total_gastos, 2, ',', '.'); ?></h2>
                </div>
            <?php endif; ?>
            <div class="mt-8 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Nombre</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Monto</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Fecha</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Categoría</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Descripción</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($gastos as $gasto): ?>
                            <tr>
                                <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-neutral-950"><?= htmlspecialchars($gasto['nombre_gasto']) ?></td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600">$<?= number_format($gasto['monto'], 2, ',', '.') ?></td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600"><?= htmlspecialchars($gasto['fecha']) ?></td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600"><?= htmlspecialchars($gasto['categoria']) ?></td>
                                <td class="px-4 py-3 text-sm text-gray-600"><?= htmlspecialchars($gasto['descripcion']) ?></td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600">
                                    <div class="flex flex-col gap-2">
                                        <button data-modal-target="editar-modal-<?= $gasto['id'] ?>" data-modal-toggle="editar-modal-<?= $gasto['id'] ?>" class="rounded-md bg-custom-gradient px-2 py-1 text-xs font-semibold text-white shadow-sm hover:opacity-90 transition">
                                            Editar
                                        </button>
                                        <a href="index.php?ruta=main&modulo=productos&accion=eliminar&id=<?= $gasto['id'] ?>" class="rounded-md bg-red-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-red-500 transition" onclick="return confirm('¿Está seguro de eliminar este gasto?')">
                                            Eliminar
                                        </a>
                                        </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div id="agregar-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-[calc(100%)] max-h-full bg-black/70 backdrop-blur-md">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm">
                <div class="flex items-center justify-between p-4 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">Agregar Nuevo Gasto</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center" data-modal-hide="agregar-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Cerrar modal</span>
                    </button>
                </div>
                <form action="index.php?ruta=main&modulo=productos" method="POST" class="p-4">
                    <div class="mb-4">
                        <label for="nombre_gasto_nuevo" class="block mb-2 text-sm font-medium text-gray-900">Nombre del Gasto</label>
                        <input type="text" name="nombre_gasto" id="nombre_gasto_nuevo" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                    </div>
                    <div class="mb-4">
                        <label for="monto_nuevo" class="block mb-2 text-sm font-medium text-gray-900">Monto</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                            <input type="number" name="monto" id="monto_nuevo" step="0.01" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full pl-10 p-2.5" />
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="fecha_nuevo" class="block mb-2 text-sm font-medium text-gray-900">Fecha</label>
                        <input type="date" name="fecha" id="fecha_nuevo" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                    </div>
                    <div class="mb-4">
                        <label for="categoria_nuevo" class="block mb-2 text-sm font-medium text-gray-900">Categoría</label>
                        <select name="categoria" id="categoria_nuevo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                            <option value="Alimentación">Alimentación</option>
                            <option value="Transporte">Transporte</option>
                            <option value="Vivienda">Vivienda</option>
                            <option value="Servicios">Servicios</option>
                            <option value="Entretenimiento">Entretenimiento</option>
                            <option value="Salud y Belleza">Salud y Belleza</option>
                            <option value="Educación">Educación</option>
                            <option value="Electronica">Electronica</option>
                            <option value="Ropa y Accesorios">Ropa y Accesorios</option>
                            <option value="Hogar y Decoración">Hogar y Decoración</option>
                            <option value="Deportes y Aire Libre">Deportes y Aire Libre</option>
                            <option value="Juguetes y Accesorios">Juguetes y Accesorios</option>
                            <option value="Automóviles y Accesorios">Automóviles y Accesorios</option>
                            <option value="Tecnología y Software">Tecnología y Software</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="descripcion_nuevo" class="block mb-2 text-sm font-medium text-gray-900">Descripción</label>
                        <textarea name="descripcion" id="descripcion_nuevo" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"></textarea>
                    </div>
                    <button type="submit" name="crearGasto" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">Agregar Gasto</button>
                </form>
            </div>
        </div>
    </div>
    
    <?php foreach ($gastos as $gasto): ?>
        <div id="editar-modal-<?= $gasto['id'] ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-[calc(100%)] max-h-full bg-black/70 backdrop-blur-md">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow-sm">
                    <div class="flex items-center justify-between p-4 border-b rounded-t">
                        <h3 class="text-lg font-semibold text-gray-900">Editar Gasto</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center" data-modal-hide="editar-modal-<?= $gasto['id'] ?>">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Cerrar modal</span>
                        </button>
                    </div>
                    <form action="index.php?ruta=main&modulo=productos" method="POST" class="p-4">
                        <input type="hidden" name="id" value="<?= $gasto['id'] ?>">
                        <div class="mb-4">
                            <label for="nombre_gasto_<?= $gasto['id'] ?>" class="block mb-2 text-sm font-medium text-gray-900">Nombre del Gasto</label>
                            <input type="text" name="nombre_gasto" id="nombre_gasto_<?= $gasto['id'] ?>" value="<?= htmlspecialchars($gasto['nombre_gasto']) ?>" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                        </div>
                        <div class="mb-4">
                            <label for="monto_<?= $gasto['id'] ?>" class="block mb-2 text-sm font-medium text-gray-900">Monto</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                                <input type="number" name="monto" id="monto_<?= $gasto['id'] ?>" step="0.01" value="<?= htmlspecialchars($gasto['monto']) ?>" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full pl-10 p-2.5" />
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="fecha_<?= $gasto['id'] ?>" class="block mb-2 text-sm font-medium text-gray-900">Fecha</label>
                            <input type="date" name="fecha" id="fecha_<?= $gasto['id'] ?>" value="<?= htmlspecialchars($gasto['fecha']) ?>" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                        </div>
                        <div class="mb-4">
                            <label for="categoria_<?= $gasto['id'] ?>" class="block mb-2 text-sm font-medium text-gray-900">Categoría</label>
                            <select name="categoria" id="categoria_<?= $gasto['id'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                <?php
                                $categorias = ['Alimentación', 'Transporte', 'Vivienda', 'Servicios', 'Entretenimiento', 'Salud y Belleza', 'Educación', 'Electronica', 'Ropa y Accesorios', 'Hogar y Decoración', 'Deportes y Aire Libre', 'Juguetes y Accesorios', 'Automóviles y Accesorios', 'Tecnología y Software', 'Otro'];
                                foreach ($categorias as $cat) {
                                    $selected = ($gasto['categoria'] == $cat) ? 'selected' : '';
                                    echo "<option value=\"" . htmlspecialchars($cat) . "\" $selected>" . htmlspecialchars($cat) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="descripcion_<?= $gasto['id'] ?>" class="block mb-2 text-sm font-medium text-gray-900">Descripción</label>
                            <textarea name="descripcion" id="descripcion_<?= $gasto['id'] ?>" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"><?= htmlspecialchars($gasto['descripcion']) ?></textarea>
                        </div>
                        <button type="submit" name="actualizarGasto" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    
    <?php if (isset($mensaje)): ?>
        <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                <span class="sr-only">Check icon</span>
            </div>
            <div class="ms-3 text-sm font-normal"><?= htmlspecialchars(str_replace('_', ' ', $mensaje)) ?></div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#toast-success" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('toast-success').style.display = 'none';
            }, 5000); // Ocultar después de 5 segundos
        </script>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div id="toast-danger" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                </svg>
                <span class="sr-only">Error icon</span>
            </div>
            <div class="ms-3 text-sm font-normal"><?= htmlspecialchars(str_replace('_', ' ', $error)) ?></div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#toast-danger" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('toast-danger').style.display = 'none';
            }, 5000); // Ocultar después de 5 segundos
        </script>
    <?php endif; ?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="assets/js/productos/modals.js"></script>
</div>