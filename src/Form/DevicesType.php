<?php

namespace App\Form;

use App\Entity\Devices;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class DevicesType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                $this->getConfiguration("Nom (*)", "Nom de l'équipement (Obligatoire)...")
            )

            ->add(
                'type',
                ChoiceType::class,
                [
                    'choices' => [
                        'CAMERA'           => 'Camera',
                        'CAPTEUR'          => 'Sensor',
                        'ALARME'           => 'Alarm',
                        'LUMINAIRE'        => 'Light',
                        'APPAREIL'         => 'Appliance',
                        'CLIMAT'           => 'Climate',
                        'SONNERIE'         => 'Bell',
                        'SMART METER'      => 'Smart Meter',
                        "BOUTON D'URGENCE" => 'Emergency'
                    ],
                    'label'    => "Type d'équipement"
                ]
            )

            ->add(
                'alerte',
                ChoiceType::class,
                [
                    'choices' => [
                        'INTRUSION'   => 'Intrusion',
                        'INCENDIE'    => 'Fire',
                        'INONDATION'  => 'Flood',
                        'OUVERTURE'   => 'Opening'
                    ],
                    'label'    => "Type d'Alerte"
                ]
            )

            ->add(
                'appliancespec',
                ChoiceType::class,
                [
                    'choices' => [
                        'INTERIEUR'       => 'Interior',
                        'EXTERIEUR'       => 'Exterior',
                        'TV'              => 'Tv',
                        'VENTILATEUR'     => 'Fan',
                        'CLIMATISEUR'     => 'Clim',
                        'MACHINE À LAVER' => 'Wash Machine',
                        'RÉFRIGÉRATEUR'   => 'Fridge'
                    ],
                    'label'    => "Light Type"
                ]
            )
            ->add(
                'smartmeterspec',
                ChoiceType::class,
                [
                    'choices' => [
                        'SOCKET'   => 'Socket',
                        'HOME'     => 'Home',
                    ],
                    'label'    => "Smart Meter Type"
                ]
            )

            ->add(
                'moduleId',
                TextType::class,
                $this->getConfiguration("ID Module (*)", "Identifiant unique du module")
            )

            ->add(
                'streamingUrl',
                TextType::class,
                $this->getConfiguration("URL Streaming (*)", "Url du streaming de la Camera...")
            )
            ->add(
                'Ipaddress',
                TextType::class,
                $this->getConfiguration("Adresse IP (*)", "Adresse IP de l'équipement dans le réseau ...")
            )

            ->add(
                'notificationMessage',
                TextareaType::class,
                $this->getConfiguration("Message (*)", "Message de Notification ...")

            );

        /*->add('connectionState')
            ->add('activation')*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Devices::class,
        ]);
    }
}
