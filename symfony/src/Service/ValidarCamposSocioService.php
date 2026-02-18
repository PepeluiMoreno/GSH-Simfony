<?php
namespace App\Service;

class ValidarCamposSocioService
{
    /**
     * Valida los campos de alta de socio, comprobando existencia de usuario, email y documento.
     * Adaptación de validarCamposAltaSocioSocio del legacy.
     *
     * @param array $camposFormRegSocio
     * @return array
     */
    public function validarCamposAltaSocioSocio(array $camposFormRegSocio): array
    {
        $resValidarCamposForm = [];

        if (!isset($camposFormRegSocio) || empty($camposFormRegSocio)) {
            $resValidarCamposForm['codError'] = '70601';
            $resValidarCamposForm['errorMensaje'] = 'Alta Socio/a: Faltan parámetros imprescindibles, codError:70601';
            return $resValidarCamposForm;
        }

        // TODO: Llamar a función que valida los campos del formulario (migrar validarCamposFormAltaSocio)
        // $resValidarCamposForm = $this->validarCamposFormAltaSocio($camposFormRegSocio);

        // TODO: Comprobar existencia de usuario (inyectar repositorio/servicio de usuario)
        // if ($resValidarCamposForm['datosFormUsuario']['USUARIO']['codError'] == '00000') {
        //     $resBuscarUsuario = $usuarioRepository->buscarUsuario(...);
        //     ...
        // }

        // TODO: Comprobar existencia de email (inyectar repositorio/servicio de usuario)
        // if ($resValidarCamposForm['datosFormMiembro']['EMAIL']['codError'] == '00000') {
        //     $resBuscarEmail = $usuarioRepository->buscarEmail(...);
        //     ...
        // }

        // TODO: Comprobar existencia de documento (inyectar repositorio/servicio de usuario)
        // if ($resValidarCamposForm['datosFormMiembro']['NUMDOCUMENTOMIEMBRO']['codError'] == '00000') {
        //     $resBuscarNumDoc = $usuarioRepository->buscarNumDoc(...);
        //     ...
        // }

        // TODO: Adaptar lógica de errores y retorno

        // return $resValidarCamposForm;
        return ['TODO' => 'Implementar validación completa de alta socio'];
    }
}
