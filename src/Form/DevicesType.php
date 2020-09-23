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
                $this->getConfiguration("Name :", "Device Name please...")
            )

            ->add(
                'type',
                ChoiceType::class,
                [
                    'choices' => [
                        'CAMERA'           => 'Camera',
                        'SENSOR'           => 'Sensor',
                        'ALARM'            => 'Alarm',
                        'LIGHT'            => 'Light',
                        'APPLIANCE'        => 'Appliance',
                        'CLIMATE'          => 'Climate',
                        'BELL'             => 'Bell',
                        'SMART METER'      => 'Smart Meter',
                        'EMERGENCY BUTTON' => 'Emergency'
                    ],
                    'label'    => "Device Type"
                ]
            )

            ->add(
                'alerte',
                ChoiceType::class,
                [
                    'choices' => [
                        'INTRUSION'  => 'Intrusion',
                        'FIRE'       => 'Fire',
                        'FLOOD'      => 'Flood',
                        'OPENING'    => 'Opening'
                    ],
                    'label'    => "Alert Type"
                ]
            )

            ->add(
                'appliancespec',
                ChoiceType::class,
                [
                    'choices' => [
                        'INTERIOR'        => 'Interior',
                        'EXTERIOR'        => 'Exterior',
                        'TV'              => 'Tv',
                        'FAN'             => 'Fan',
                        'CLIM'            => 'Clim',
                        'WASH MACHINE'    => 'Wash Machine',
                        'FRIDGE'          => 'Fridge'
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
                $this->getConfiguration("Module ID :", "Unique Module ID")
            )

            ->add(
                'streamingUrl',
                TextType::class,
                $this->getConfiguration("Stream URL :", "Camera Url streaming ...")
            )
            ->add(
                'Ipaddress',
                TextType::class,
                $this->getConfiguration("IP Address :", "Device IP in network ...")
            )

            ->add(
                'notificationMessage',
                TextareaType::class,
                $this->getConfiguration("Notification Message :", "Message please...")

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
