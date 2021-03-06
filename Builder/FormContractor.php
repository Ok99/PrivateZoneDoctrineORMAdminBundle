<?php

namespace Ok99\PrivateZoneCore\DoctrineORMAdminBundle\Builder;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Sonata\DoctrineORMAdminBundle\Builder\FormContractor as BaseFormContractor;

class FormContractor extends BaseFormContractor
{
    public function getDefaultOptions($type, \Sonata\AdminBundle\Admin\FieldDescriptionInterface $fieldDescription)
    {
        $options                             = array();
        $options['sonata_field_description'] = $fieldDescription;

        if (in_array($type, array('sonata_type_model', 'sonata_type_model_list', 'ok99_privatezone_type_image', 'ok99_privatezone_type_file', 'sonata_type_model_hidden', 'sonata_type_model_autocomplete'))) {

            if ($fieldDescription->getOption('edit') == 'list') {
                throw new \LogicException('The ``sonata_type_model`` type does not accept an ``edit`` option anymore, please review the UPGRADE-2.1.md file from the SonataAdminBundle');
            }

            $options['class']         = $fieldDescription->getTargetEntity();
            $options['model_manager'] = $fieldDescription->getAdmin()->getModelManager();

            if ($type == 'sonata_type_model_autocomplete') {
                if (!$fieldDescription->getAssociationAdmin()) {
                    throw new \RuntimeException(sprintf('The current field `%s` is not linked to an admin. Please create one for the target entity: `%s`', $fieldDescription->getName(), $fieldDescription->getTargetEntity()));
                }
            }

        } elseif ($type == 'sonata_type_admin') {

            if (!$fieldDescription->getAssociationAdmin()) {
                throw new \RuntimeException(sprintf('The current field `%s` is not linked to an admin. Please create one for the target entity : `%s`', $fieldDescription->getName(), $fieldDescription->getTargetEntity()));
            }

            if (!in_array($fieldDescription->getMappingType(), array(ClassMetadataInfo::ONE_TO_ONE, ClassMetadataInfo::MANY_TO_ONE ))) {
                throw new \RuntimeException(sprintf('You are trying to add `sonata_type_admin` field `%s` which is not One-To-One or  Many-To-One. Maybe you want `sonata_model_list` instead?', $fieldDescription->getName()));
            }

            $options['data_class'] = $fieldDescription->getAssociationAdmin()->getClass();
            $fieldDescription->setOption('edit', $fieldDescription->getOption('edit', 'admin'));

        } elseif ($type == 'sonata_type_collection' || $type == 'ok99_privatezone_type_media_collection') {

            if (!$fieldDescription->getAssociationAdmin()) {
                throw new \RuntimeException(sprintf('The current field `%s` is not linked to an admin. Please create one for the target entity : `%s`', $fieldDescription->getName(), $fieldDescription->getTargetEntity()));
            }

            $options['type']         = 'sonata_type_admin';
            $options['modifiable']   = true;
            $options['type_options'] = array(
                'sonata_field_description' => $fieldDescription,
                'data_class'               => $fieldDescription->getAssociationAdmin()->getClass()
            );

        }

        return $options;
    }
}
