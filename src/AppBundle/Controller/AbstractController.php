<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Repository;
use Symfony\Component\Translation\TranslatorInterface;

class AbstractController extends Controller
{
    /** @return Repository\LectureRepository */
    protected function getLectureRepository()
    {
        return $this->get('repository.lecture');
    }

    /** @return Repository\LectureReactionRepository */
    protected function getLectureReactionRepository()
    {
        return $this->get('repository.lecture_reaction');
    }

    /** @return Repository\LecturerRepository */
    protected function getLecturerRepository()
    {
        return $this->get('repository.lecturer');
    }

    /** @return Repository\EventRepository */
    protected function getEventRepository()
    {
        return $this->get("repository.event");
    }

    /** @return Repository\FieldRepository */
    protected function getFieldRepository()
    {
        return $this->get("repository.field");
    }

    /** @return Repository\TagRepository */
    protected function getTagRepository()
    {
        return $this->get("repository.tag");
    }

    /** @return Repository\CityRepository */
    protected function getCityRepository()
    {
        return $this->get("repository.city");
    }

    /** @return \Knp\Component\Pager\Paginator */
    protected function getPager()
    {
        return $this->get('knp_paginator');
    }

    /** @return EntityManager */
    protected function getEm()
    {
        return $this->get("doctrine.orm.entity_manager");
    }

    /** @return TranslatorInterface */
    protected function getTranslator()
    {
        return $this->get("translator");
    }
} 
