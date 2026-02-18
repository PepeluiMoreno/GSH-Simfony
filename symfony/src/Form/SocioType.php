<?php

namespace App\Form;

use App\Entity\Socio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SocioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoDocumento', ChoiceType::class, [
                'choices' => [
                    'DNI' => 'DNI',
                    'NIE' => 'NIE',
                    'Pasaporte' => 'Pasaporte',
                ],
                'label' => 'Tipo de documento',
            ])
            ->add('numeroDocumento', TextType::class, [
                'label' => 'Nº documento',
            ])
            ->add('paisExpedicion', TextType::class, [
                'label' => 'País expedición',
            ])
            ->add('nombre', TextType::class)
            ->add('primerApellido', TextType::class, [
                'label' => 'Primer apellido',
            ])
            ->add('segundoApellido', TextType::class, [
                'required' => false,
                'label' => 'Segundo apellido',
            ])
            ->add('anioNacimiento', IntegerType::class, [
                'label' => 'Año de nacimiento',
            ])
            ->add('sexo', ChoiceType::class, [
                'choices' => [
                    'Hombre' => 'H',
                    'Mujer' => 'M',
                ],
            ])
            ->add('telefono', TextType::class, [
                'required' => false,
            ])
            ->add('movil', TextType::class, [
                'required' => false,
            ])
            ->add('email', EmailType::class)
            ->add('profesion', TextType::class, [
                'required' => false,
            ])
            ->add('nivelEstudios', TextType::class, [
                'required' => false,
                'label' => 'Nivel de estudios',
            ])
            ->add('direccion', TextType::class)
            ->add('paisDomicilio', TextType::class, [
                'label' => 'País domicilio',
            ])
            ->add('codigoPostal', TextType::class, [
                'label' => 'Código postal',
            ])
            ->add('localidad', TextType::class)
            ->add('agrupacionTerritorial', TextType::class, [
                'label' => 'Agrupación territorial',
            ])
            ->add('tipoCuota', ChoiceType::class, [
                'choices' => [
                    'Ordinaria' => 'ordinaria',
                    'Reducida' => 'reducida',
                    'Simpatizante' => 'simpatizante',
                ],
                'label' => 'Tipo de cuota',
            ])
            ->add('aportacionAnual', IntegerType::class, [
                'label' => 'Aportación anual',
            ])
            ->add('procedimientoCobro', ChoiceType::class, [
                'choices' => [
                    'Domiciliación bancaria' => 'domiciliacion',
                    'PayPal' => 'paypal',
                ],
                'label' => 'Procedimiento de cobro',
            ])
            ->add('iban', TextType::class, [
                'required' => false,
                'label' => 'IBAN',
            ])
            ->add('paypal', TextType::class, [
                'required' => false,
                'label' => 'Email PayPal',
            ])
            ->add('usuario', TextType::class)
            ->add('clave', PasswordType::class, [
                'label' => 'Contraseña',
            ])
            ->add('claveRepetida', PasswordType::class, [
                'label' => 'Repite contraseña',
            ])
            ->add('comentarios', TextareaType::class, [
                'required' => false,
            ])
            ->add('aceptaPrivacidad', CheckboxType::class, [
                'label' => 'Acepto la política de privacidad',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Socio::class,
        ]);
    }
}
