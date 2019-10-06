<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(type="string", length=255, unique=true)
     * @Serializer\Type("string")
     */
    private $hash_ativacao;

    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Type("bool")
     */
    private $is_autenticado = false;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getNome(): ?string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     *
     * @return $this
     */
    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * @param string $login
     *
     * @return $this
     */
    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSenha(): ?string
    {
        return $this->senha;
    }

    /**
     * @param string $senha
     *
     * @return $this
     */
    public function setSenha(string $senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsAutenticado(): ?bool
    {
        return $this->is_autenticado;
    }

    /**
     * @param bool|null $is_autenticado
     *
     * @return $this
     */
    public function setIsAutenticado(?bool $is_autenticado): self
    {
        $this->is_autenticado = $is_autenticado;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHashAtivacao(): ?string
    {
        return $this->hash_ativacao;
    }

    /**
     * @param $hash_ativacao
     *
     * @return $this
     */
    public function setHashAtivacao($hash_ativacao): self
    {
        $this->hash_ativacao = $hash_ativacao;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     *
     * @throws \Exception
     */
    public function updatedTimestamps(): void
    {
        $this->setUpdatedAt(new \DateTime('now'));

        if (!$this->getCreatedAt()) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
          'id' => $this->getId(),
          'nome' => $this->getNome(),
          'login' => $this->getLogin(),
          'email' => $this->getEmail(),
          'senha' => $this->getSenha(),
          'hash_ativacao' => $this->getHashAtivacao(),
          'is_autenticado' => $this->getIsAutenticado()
        ];
    }
}
