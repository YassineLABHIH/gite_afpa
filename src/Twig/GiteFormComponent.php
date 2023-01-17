<?php

namespace App\Twig;

use App\Entity\Gite;
use App\Form\GiteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('gite_form')]
class GiteFormComponent extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(fieldName: 'data')]
    public ?Gite $gite = null;
    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(GiteType::class, $this->gite);
    }

    #[LiveAction]
    public function addGiteService()
    {
        $this->formValues['giteServices'][] = [];
    }

    #[LiveAction]
    public function removeGiteService(#[LiveArg] int $index)
    {
        unset($this->formValues['giteServices'][$index]);
    }
}