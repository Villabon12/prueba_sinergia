<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Crear tabla de tipos de clientes
        Schema::create('tipos_clientes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 15); // Tipo de cliente (nacional/internacional)
            $table->timestamps();
        });

        // Crear tabla de clientes
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo', 55);
            $table->string('telefono', 15);
            $table->string('direccion', 100);
            $table->string('email', 50)->unique();
            $table->foreignId('tipo_cliente_id')->constrained('tipos_clientes')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes(); // Permite eliminar de manera suave (no física)
        });

        // Crear tabla de tipos de productos
        Schema::create('tipos_productos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 45); // Tipo de producto (terrestre/marítimo)
            $table->timestamps();
        });

        // Crear tabla de productos
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45);
            $table->text('descripcion')->nullable();
            $table->foreignId('tipo_producto_id')->constrained('tipos_productos')->onDelete('cascade');
            $table->timestamps();
        });

        // Crear tabla de tipos de bodegas
        Schema::create('tipos_bodegas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 45); // Tipo de bodega (terrestre/marítima)
            $table->timestamps();
        });

        // Crear tabla de bodegas
        Schema::create('bodegas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45);
            $table->string('ubicacion', 100);
            $table->integer('capacidad_almacenamiento');
            $table->foreignId('tipo_bodega_id')->constrained('tipos_bodegas')->onDelete('cascade');
            $table->timestamps();
        });

        // Crear tabla de puertos (solo para logística marítima)
        Schema::create('puertos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45);
            $table->string('ubicacion', 100); // Nacional/Internacional
            $table->integer('capacidad_recepcion');
            $table->timestamps();
        });

        // Crear tabla de logística terrestre
        Schema::create('logistica_terrestre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('bodega_id')->constrained('bodegas')->onDelete('cascade');
            $table->integer('cantidad');
            $table->timestamp('fecha_registro')->useCurrent();
            $table->timestamp('fecha_entrega')->nullable();
            $table->decimal('precio_envio', 10, 2);
            $table->string('placa_vehiculo', 8);
            $table->string('numero_guia', 10)->unique();
            $table->decimal('descuento_aplicado', 10, 2)->default(0);
            $table->timestamps();
        });

        // Crear tabla de logística marítima
        Schema::create('logistica_maritima', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('puerto_id')->constrained('puertos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->timestamp('fecha_registro')->useCurrent();
            $table->timestamp('fecha_entrega')->nullable();
            $table->decimal('precio_envio', 10, 2);
            $table->string('numero_flotilla', 8);
            $table->string('numero_guia', 10)->unique();
            $table->decimal('descuento_aplicado', 10, 2)->default(0);
            $table->timestamps();
        });

        // Crear tabla de detalles de envío (productos asociados a un envío)
        Schema::create('detalles_envios', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('envio_id')->constrained('logistica_terrestre')->onDelete('cascade')->nullable();
            $table->foreignId('envio_maritimo_id')->constrained('logistica_maritima')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Eliminar las tablas creadas.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles_envios');
        Schema::dropIfExists('logistica_maritima');
        Schema::dropIfExists('logistica_terrestre');
        Schema::dropIfExists('puertos');
        Schema::dropIfExists('bodegas');
        Schema::dropIfExists('tipos_bodegas');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('tipos_productos');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('tipos_clientes');
    }
};
