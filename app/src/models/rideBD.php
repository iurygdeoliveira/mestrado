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

    protected readonly string $table;

    protected static $required = [];

    protected static $preventChange = ['id'];


    use dbPreventChange;


    public function bootstrap(string $riderID, string $activityID = null)
    {
        $this->table = "rider" . $riderID;

        if ($activityID) {
            $data = $this->findById(intval($activityID));

            if ($data instanceof rideBD) {
                $this->id = $data->id;
            }
        }
    }

    public function setFail(bool $value)
    {
        $this->fail = $value;
    }

    public function setMessage(string $value)
    {
        if (empty($this->message)) {
            $this->message = $value;
            return $this->message;
        }

        $this->message = "{$this->message}. {$value}";
        return $this->message;
    }

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
            $this->message = $this->setMessage("Erro ao Salvar");
            return false;
        }

        $this->message = "Cadastro realizado com sucesso";
        $this->fail = false;
        return $userId;
    }

    private function updating($userId)
    {

        $this->update($this->preventChange(self::$preventChange), "id = :id", "id={$userId}");
        if ($this->fail()) {
            $this->message = $this->setMessage("Erro ao Atualizar");
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
            $this->message = "Preencha todos os campos obrigatórios";
            $this->fail = true;
            return false;
        }
        return true;
    }
}
