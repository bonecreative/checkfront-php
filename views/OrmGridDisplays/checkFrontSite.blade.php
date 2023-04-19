@extends('fuqu-prototype-ui::private')

@section('content')

    @component('fuqu-prototype-ui::partials._title')
        @slot('icon', 'bank')
        @slot('title', 'CheckFrontSite')
    @endcomponent

    @component('fuqu-prototype-ui::partials._powerGrid')
        @slot('data_feed',route('orm::check-front-sites::grid.index', ['check_front_account' => $check_front_account]))
        @slot('display_cols',['domain'])
        @slot('delete', route('orm::check-front-sites::grid.destroy', ['check_front_account' => $check_front_account, 'check_front_site' => '_ID_']))
        @slot('create', 'checkfront::OrmForms.checkFrontSite')
        @slot('create_slots', ['check_front_account' => $check_front_account])
    @endcomponent

@append