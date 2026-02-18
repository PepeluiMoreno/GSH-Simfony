<?php
namespace App\Service;

class ComboListaService
{
    /**
     * Genera un <select> HTML a partir de un array de valores y descripciones.
     *
     * @param array $parValor Array asociativo valor => descripción
     * @param string $identificadorCampo Nombre/id del campo select
     * @param string|null $valorPrevio Valor seleccionado previamente
     * @param string|null $descPrevio Descripción del valor previo
     * @param string $valorInicial Valor por defecto
     * @param string $descInicial Descripción por defecto
     * @return string HTML del <select>
     */
    public function renderCombo(array $parValor, string $identificadorCampo, $valorPrevio = null, $descPrevio = null, $valorInicial = '', $descInicial = ''): string
    {
        $lista = "<select name=\"$identificadorCampo\" size=\"1\">";
        foreach ($parValor as $valorCod => $descCod) {
            $lista .= "<option value=\"$valorCod\">$descCod</option>";
        }
        if (!isset($valorPrevio) || empty($valorPrevio)) {
            $lista .= '<option value=' . $valorInicial . ' selected="selected">' . $descInicial . '</option>';
        } else {
            $lista .= '<option value=' . $valorPrevio . ' selected="selected">' . $descPrevio . '</option>';
        }
        $lista .= "</select>";
        return $lista;
    }
}
