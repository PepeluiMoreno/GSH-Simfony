<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Socio
{
    /**
     * @Assert\NotBlank()
     */
    private $tipoDocumento;

    /**
     * @Assert\NotBlank()
     */
    private $numeroDocumento;

    /**
     * @Assert\NotBlank()
     */
    private $paisExpedicion;

    /**
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @Assert\NotBlank()
     */
    private $primerApellido;

    private $segundoApellido;

    /**
     * @Assert\NotBlank()
     */
    private $anioNacimiento;

    /**
     * @Assert\NotBlank()
     */
    private $sexo;

    private $telefono;
    private $movil;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    private $profesion;
    private $nivelEstudios;

    /**
     * @Assert\NotBlank()
     */
    private $direccion;

    /**
     * @Assert\NotBlank()
     */
    private $paisDomicilio;

    /**
     * @Assert\NotBlank()
     */
    private $codigoPostal;

    /**
     * @Assert\NotBlank()
     */
    private $localidad;

    /**
     * @Assert\NotBlank()
     */
    private $agrupacionTerritorial;

    /**
     * @Assert\NotBlank()
     */
    private $tipoCuota;

    /**
     * @Assert\NotBlank()
     * @Assert\Positive()
     */
    private $aportacionAnual;

    /**
     * @Assert\NotBlank()
     */
    private $procedimientoCobro;

    private $iban;
    private $paypal;

    /**
     * @Assert\NotBlank()
     */
    private $usuario;

    /**
     * @Assert\NotBlank()
     */
    private $clave;

    /**
     * @Assert\NotBlank()
     */
    private $claveRepetida;

    private $comentarios;

    /**
     * @Assert\IsTrue(message="Debes aceptar la política de privacidad.")
     */
    private $aceptaPrivacidad;

    // Getters y setters...
}
