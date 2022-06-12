<?php

namespace App\Traits\Queries;

use Base\Concretes\BaseQuery;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

trait DefaultQueries
{
    /**
     * İzin verilen filtreler tanımlanıyor.
     *
     * @param $filters
     * @return $this
     */
    public function allowedFilters($filters): self
    {
        $filters = is_array($filters) ? $filters : func_get_args();

        $this->filters($filters);

        return parent::allowedFilters($filters);
    }

    /**
     * İzin verilen ilişkiler tanımlanıyor.
     *
     * @param $includes
     * @return $this
     */
    public function allowedIncludes($includes): self
    {
        $includes = is_array($includes) ? $includes : func_get_args();

        $this->includes($includes);

        return parent::allowedIncludes($includes);
    }

    /**
     * İzin verilen sıralamalar tanımlanıyor.
     *
     * @param $sorts
     * @return DefaultQueries|BaseQuery
     */
    public function allowedSorts($sorts): self
    {
        if ($this->request->sorts()->isEmpty()) {
            return $this;
        }

        $sorts = is_array($sorts) ? $sorts : func_get_args();

        $this->sorts($sorts);

        return parent::allowedSorts($sorts);
    }

    /**
     * Filtre izinleri
     *
     * @param $filters
     * @return void
     */
    private function filters(&$filters): void
    {
        $this->filterCreatedBy($filters);
        $this->filterUpdatedBy($filters);
        $this->filterDeletedBy($filters);
        $this->filterTimestamps($filters);
    }

    /**
     * İlişki izinleri
     *
     * @param $includes
     * @return void
     */
    private function includes(&$includes): void
    {
        $this->includeCreatedBy($includes);
        $this->includeUpdatedBy($includes);
        $this->includeDeletedBy($includes);
    }

    /**
     * Sıralama izinleri
     *
     * @param $sorts
     * @return void
     */
    private function sorts(&$sorts): void
    {
        $sorts[] = AllowedSort::field($this->getModel()->getKeyName());

        $this->sortCreatedBy($sorts);
        $this->sortUpdatedBy($sorts);
        $this->sortDeletedBy($sorts);
        $this->sortTimestamps($sorts);
    }


    /**
     * Model'de CreatedBy trait ekliyse created_by sıralaması izin verilenler listesine eklendi.
     *
     * @param $sorts
     * @return void
     */
    private function sortCreatedBy(&$sorts): void
    {
        if (method_exists($this->getModel(), 'createdBy')) {
            $sorts[] = AllowedSort::field('created_by');
        }
    }

    /**
     * Model'de UpdatedBy trait ekliyse updated_by sıralaması izin verilenler listesine eklendi.
     *
     * @param $sorts
     * @return void
     */
    private function sortUpdatedBy(&$sorts): void
    {
        if (method_exists($this->getModel(), 'updatedBy')) {
            $sorts[] = AllowedSort::field('updated_by');
        }
    }

    /**
     * Model'de DeletedBy trait ekliyse deleted_by sıralaması izin verilenler listesine eklendi.
     *
     * @param $sorts
     * @return void
     */
    private function sortDeletedBy(&$sorts): void
    {
        if (method_exists($this->getEloquentBuilder(), 'deletedBy')) {
            $sorts[] = AllowedSort::field('deleted_at');
            $sorts[] = AllowedSort::field('deleted_by');
        }
    }

    /**
     * Model'de timestamps true belirlendiyse created_at ve updated_at sıralaması izin verilenler listesine eklendi.
     *
     * @param $sorts
     * @return void
     */
    private function sortTimestamps(&$sorts): void
    {
        if ($this->getModel()->timestamps) {
            $sorts[] = AllowedSort::field('created_at');
            $sorts[] = AllowedSort::field('updated_at');
        }
    }

    /**
     * Model'de CreatedBy trait ekliyse createdBy relation'u izin verilenler listesine eklendi.
     *
     * @param $includes
     * @return void
     */
    private function includeCreatedBy(&$includes): void
    {
        if (method_exists($this->getModel(), 'createdBy')) {
            $includes[] = AllowedInclude::relationship('createdBy');
        }
    }

    /**
     * Model'de UpdatedBy trait ekliyse updatedBy relation'u izin verilenler listesine eklendi.
     *
     * @param $includes
     * @return void
     */
    private function includeUpdatedBy(&$includes): void
    {
        if (method_exists($this->getModel(), 'updatedBy')) {
            $includes[] = AllowedInclude::relationship('updatedBy');
        }
    }

    /**
     * Model'de DeletedBy trait ekliyse deletedBy relation'u izin verilenler listesine eklendi.
     *
     * @param $includes
     * @return void
     */
    private function includeDeletedBy(&$includes): void
    {
        if (method_exists($this->getModel(), 'deletedBy')) {
            $includes[] = AllowedInclude::relationship('deletedBy');
        }
    }

    /**
     * Model'de CreatedBy trait ekliyse created_by filtresi izin verilenler listesine eklendi.
     *
     * @param $filters
     * @return void
     */
    private function filterCreatedBy(&$filters): void
    {
        if (method_exists($this->getModel(), 'createdBy')) {
            $filters[] = AllowedFilter::exact('created_by');
        }
    }

    /**
     * Model'de UpdatedBy trait ekliyse updated_by filtresi izin verilenler listesine eklendi.
     *
     * @param $filters
     * @return void
     */
    private function filterUpdatedBy(&$filters): void
    {
        if (method_exists($this->getModel(), 'updatedBy')) {
            $filters[] = AllowedFilter::exact('updated_by');
        }
    }

    /**
     * Model'de DeletedBy trait ekliyse deleted_by filtresi izin verilenler listesine eklendi.
     *
     * @param $filters
     * @return void
     */
    private function filterDeletedBy(&$filters): void
    {
        if (method_exists($this->getEloquentBuilder(), 'deletedBy')) {
            $filters[] = AllowedFilter::trashed();
            $filters[] = AllowedFilter::exact('deleted_by');
            $filters[] = AllowedFilter::exact('deleted_at');
        }
    }

    /**
     * Model'de timestamps true belirlendiyse created_at ve updated_at filtresi izin verilenler listesine eklendi.
     *
     * @param $filters
     * @return void
     */
    private function filterTimestamps(&$filters): void
    {
        if ($this->getModel()->timestamps) {
            $filters[] = AllowedFilter::exact('created_at');
            $filters[] = AllowedFilter::exact('updated_at');
        }
    }
}
