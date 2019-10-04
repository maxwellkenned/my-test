<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
 * @UniqueEntity("login", message="Usuario já cadastrado com esse login.")
 * @UniqueEntity("email", message="Usuario já cadastrado com esse email.")
 */
class Usuario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Type("int")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="O nome é obrigatório.")
     * @Serializer\Type("string")
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\NotBlank(message="O login é obrigatório.")
     * @Serializer\Type("string")
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="O email é obrigatório.")
     * @Assert\Email(message="Esse não é um email válido.")
     * @Serializer\Type("string")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="A senha é obrigatória.")
     * @Assert\Regex(
     *     "/(?=^.{6,}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$/",
     *      message="A senha deve conter pelo menos 6 caracteres e contendo pelo menos uma letra minúscula, uma letra
     *      maiúscula e números"
     * )
     * @Serializer\Type("string")
     */
    private $senha;

    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Type("bool")
     */
    private $is_autenticado = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSenha(): ?string
    {
        return $this->senha;
    }

    public function setSenha(string $senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    public function getIsAutenticado(): ?bool
    {
        return $this->is_autenticado;
    }

    public function setIsAutenticado(?bool $is_autenticado): self
    {
        $this->is_autenticado = $is_autenticado;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
          'id' => $this->getId(),
          'nome' => $this->getNome(),
          'login' => $this->getLogin(),
          'email' => $this->getEmail(),
          'senha' => $this->getSenha(),
          'is_autenticado' => $this->getIsAutenticado()
        ];
    }
}
