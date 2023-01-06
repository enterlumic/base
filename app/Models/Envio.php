<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    use HasFactory;
    public $table = "envio";
    protected $fillable =   [ 'IdEnvio'
                            , 'IdEnvioP'
                            , 'NroEnvio'
                            , 'NumeroDireccion'
                            , 'Guia'
                            , 'IdCliente'
                            , 'IdClienteUbicacionOrigen'
                            , 'IdClienteUbicacionDestino'
                            , 'IdTipoPaquete'
                            , 'Largo'
                            , 'Ancho'
                            , 'Alto'
                            , 'Peso'
                            , 'Precio'
                            , 'Insumos'
                            , 'Picking'
                            , 'Seguro'
                            , 'PrecioGuia'
                            , 'precio_individual'
                            , 'Contenido'
                            , 'Comentarios'
                            , 'IdTipoEnvio'
                            , 'IdTookan'
                            , 'IdTookanD'
                            , 'IdEstafeta'
                            , 'IdFedex'
                            , 'IdRedpack'
                            , 'IdPaquetexpress'
                            , 'IdSendex'
                            , 'IdDHL'
                            , 'IdJT'
                            , 'IdProducto'
                            , 'FechaRecoleccion'
                            , 'FechaEntrega'
                            , 'EstatusReplicacion'
                            , 'Origen'
                            , 'EstatusEnvioEstafeta'
                            , 'EstatusEnvioFedex'
                            , 'EstatusEnvioRedpack'
                            , 'EstatusEnvioPaquetexpress'
                            , 'EstatusEnvioSendex'
                            , 'EstatusEnvioDHL'
                            , 'EstatusEnvioJT'
                            , 'EstatusEnvio'
                            , 'EstatusEnvioD'
                            , 'PCE'
                            , 'RN'
                            , 'PickupTrackLink'
                            , 'DeliveryTrackLink'
                            , 'ReferenciaMK'
                            , 'Creado'
                            , 'CreadoPor'
                            , 'Modificado'
                            , 'ModificadoPor'
                            , 'FechaReplicacion'
                            , 'IdMedioContacto'
                            , 'Activo'];

    public $timestamps = false;
}
