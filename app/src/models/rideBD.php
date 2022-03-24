<?php

declare(strict_types=1);

namespace src\models;

use src\core\Model;
use src\traits\dbPreventChange;
use src\traits\encryptPass;
use src\traits\Validate;
use Exception;
use PDOException;

class rideBD extends Model
{

    protected static $entity = "ride";

    protected static $required = ['creator', 'rider_id'];

    protected static $preventChange = ['id'];


    use dbPreventChange;

    public function save()
    {
        // Validando Campos obrigatórios
        if (!$this->validating()) {
            return false;
        }

        // Update
        if (!empty($this->id)) {

            $userId = $this->id;
            if (!$this->updating($userId)) {
                return false;
            }
        }

        // Create
        if (empty($this->id)) {

            $userId = $this->creating();

            if (!$userId) {
                return false;
            }
        }

        // Realimentando data com um objeto stdClass
        $this->data = $this->findById(intval($userId))->data();
        return $userId;
    }

    private function creating()
    {


        $userId = $this->create($this->preventChange(self::$preventChange));

        if ($this->fail()) {
            $this->message = "Erro ao cadastrar, entre em contato com o suporte";
            $this->fail = true;
            return false;
        }

        $this->message = "Cadastro realizado com sucesso";
        $this->fail = null;
        return $userId;
    }

    private function updating($userId)
    {

        $this->update($this->preventChange(self::$preventChange), "id = :id", "id={$userId}");
        if ($this->fail()) {
            $this->message = "Erro ao atualizar";
            $this->fail = true;
            return false;
        }

        $this->message = "Dados Atualizados com Sucesso";
        $this->fail = false;
        return true;
    }

    private function validating()
    {
        // Validando Campos obrigatórios
        if (!$this->required(self::$required)) {
            $this->message = "Preencha todos os campos obrigatórios: dataset e rider_id";
            $this->fail = true;
            return false;
        }
        return true;
    }
}
