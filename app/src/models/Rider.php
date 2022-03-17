<?php

declare(strict_types=1);

namespace api\src\models;

use src\core\Model;
use src\traits\dbPreventChange;
use src\traits\encryptPass;
use src\traits\Validate;
use Exception;
use PDOException;

class Rider extends Model
{

    protected static $entity = "user";

    protected static $required = [
        'fullname', 'cpf', 'emailaddress', 'password', 'phone'
    ];

    protected static $preventChange = [
        'id', 'created_at', 'updated_at'
    ];

    protected static $columns = [
        'fullname' => 'fullname',
        'cpf' => 'cpf',
        'emailaddress' => 'emailaddress',
        'password' => 'password',
        'phone' => 'phone',
        'status' => 'status',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at',
    ];

    use dbPreventChange;

    /**
     * Inicializar os dados para cadastrar no banco
     */
    public function boostrap(string $fullname, string $cpf, string $emailaddress, string $password, string $phone)
    {
        $this->fullname = $fullname;
        $this->cpf = $cpf;
        $this->emailaddress = $emailaddress;
        $this->password = $password;
        $this->phone = $phone;
        return $this;
    }

    public function findByEmail(string $email, string $columns = "*")
    {
        $find = $this->find("emailaddress = :emailaddress", "emailaddress={$email}", $columns);
        return $find->fetch();
    }

    public function findByCPF(string $cpf, string $columns = "*")
    {
        $find = $this->find("cpf = :cpf", "cpf={$cpf}", $columns);
        return $find->fetch();
    }

    public function save(): bool
    {

        // Update
        if (!empty($this->id)) {

            $userId = $this->id;
            if (!$this->updating($userId)) {
                return false;
            }
        }

        // Create
        if (empty($this->id)) {

            //code...
            $userId = $this->creating();

            if (!$userId) {
                return false;
            }
        }

        // Realimentando data com um objeto stdClass
        $this->data = $this->findById(intval($userId))->data();
        return true;
    }

    private function creating()
    {
        // Não é permitido salvar o mesmo email
        if ($this->findByEmail($this->emailaddress, "id")) {

            $this->message = "O email informado já está cadastrado";
            $this->fail = true;
            return false;
        }

        // Não é permitido salvar o mesmo cpf
        if ($this->findByCPF($this->cpf, "id")) {

            $this->message = "O cpf informado já está cadastrado";
            $this->fail = true;
            return false;
        }

        $userId = $this->create($this->preventChange(self::$preventChange));

        if ($this->fail()) {
            $this->message = "Erro ao cadastrar, entre em contato com o suporte";
            dump($this->fail());
            die;
            return false;
        }

        $this->message = "Cadastro realizado com sucesso, você será redirecionado em 7 segundos";
        $this->fail = null;
        return $userId;
    }

    private function updating($userId)
    {
        // Pesquisando outros usuarios no BD com mesmo email
        $terms = "email = :email AND id != :id";
        $params = "email={$this->emailaddress}&id={$userId}";
        if ($this->find($terms, $params, "id")->fetch()) {
            $this->message = "O email informado já está cadastrado.";
            $this->fail = true;
            return false;
        }

        $this->update($this->preventChange(self::$preventChange), "id = :id", "id={$userId}");
        if ($this->fail()) {
            $this->message = "Erro ao atualizar, entre em contato com o suporte";
            return false;
        }

        $this->message = "Dados Atualizados com Sucesso";
        $this->fail = false;
        return true;
    }
}
