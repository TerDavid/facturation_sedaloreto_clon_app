<?php
namespace App\Models;

use App\Models\Catalogs\IdentityDocumentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'code_suministro',
        'nombre',
        'apellido',
        'dni',
        'direccion',
        'telefono',
        'email',
        'id_manzana',
        'categoria',
        'tarifa_id',
        'id_consumo_sin_medidor',
    ];

    public function manzana()
    {
        return $this->belongsTo(Manzana::class, 'id_manzana');
    }

    public function tarifa()
    {
        return $this->belongsTo(Tarifa::class);
    }

    public function consumoSinMedidor()
    {
        return $this->belongsTo(ConsumoSinMedidor::class, 'id_consumo_sin_medidor');
    }

    public function medidor()
    {
        return $this->hasOne(Medidor::class, 'cliente_id');
    }

    public function consumos()
    {
        return $this->hasMany(Consumo::class, 'cliente_id');
    }

    public function identity_document_type()
    {
        return $this->belongsTo(IdentityDocumentType::class, 'identity_document_type_id');
    }

    public function getAddressFullAttribute()
    {
        $address = trim($this->direccion);
        $address = ($address === '-' || $address === '') ? '' : $address . ' ,';
        if ($address === '') {
            return '';
        }

        if (!is_null($this->department_id) && !is_null($this->province_id) && !is_null($this->district_id)) {
            return "{$address} {$this->department->description} - {$this->province->description} - {$this->district->description}";
        } else {
            return $address;
        }
    }
}
