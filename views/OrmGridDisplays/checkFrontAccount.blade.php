@extends('fuqu-prototype-ui::private')

@section('content')

    @component('fuqu-prototype-ui::partials._title')
        @slot('icon', 'bank')
        @slot('title', 'CheckFrontAccount')
    @endcomponent

    @component('fuqu-prototype-ui::partials._powerGrid')
        @slot('data_feed',route('orm::check-front-accounts::grid.index'))
        @slot('display_cols',['api','token','created_at'])
        @slot('actions', [
            ['route' => route('orm::check-front-sites::display.index', ['check_front_account' => '_ID_']), 'modal' => false, 'icon' => 'list'],
            ['route' => route('orm::check-front-accounts::display.edit', ['check_front_account' => '_ID_']), 'modal' => true, 'icon' => 'edit'],
        ])
        @slot('delete', route('orm::check-front-accounts::grid.destroy', '_ID_'))
        @slot('create', 'checkfront::OrmForms.checkFrontAccount')
    @endcomponent

@append