<?php

namespace Eportal\Providers;

use Eportal\Repositories\Department\DepartmentRepository;
use Eportal\Repositories\Department\DepartmentRepositoryInterface;
use Eportal\Repositories\EportalClass\ClassRepository;
use Eportal\Repositories\EportalClass\ClassRepositoryInterface;
use Eportal\Repositories\School\SchoolRepository;
use Eportal\Repositories\School\SchoolRepositoryInterface;
use Eportal\Repositories\Session\SessionRepository;
use Eportal\Repositories\Session\SessionRepositoryInterface;
use Eportal\Repositories\Subject\SubjectRepository;
use Eportal\Repositories\Subject\SubjectRepositoryInterface;
use Eportal\Repositories\Term\TermRepository;
use Eportal\Repositories\Term\TermRepositoryInterface;
use Eportal\Repositories\User\UserService;
use Eportal\Repositories\User\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class EportalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserServiceInterface::class, function(){
            return new UserService();
        });
        $this->app->bind(SessionRepositoryInterface::class, function(){
            return new SessionRepository();
        });
        $this->app->bind(TermRepositoryInterface::class, function(){
            return new TermRepository();
        });
        $this->app->bind(SchoolRepositoryInterface::class, function(){
            return new SchoolRepository();
        });
        $this->app->bind(ClassRepositoryInterface::class, function(){
            return new ClassRepository();
        });
        $this->app->bind(DepartmentRepositoryInterface::class, function(){
            return new DepartmentRepository();
        });
        $this->app->bind(SubjectRepositoryInterface::class, function(){
           return new SubjectRepository();
        });
    }
}
