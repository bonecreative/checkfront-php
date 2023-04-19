@component('fuqu-prototype-ui::forms.wrapperAuto')

    @if(!empty($unique))
        @slot('unique', $unique)
    @endif

    @slot('title', ((empty($check_front_account))? 'CheckFrontAccount': $check_front_account->getKey()))

    @slot('formOpen')
        <div class="form">
            <form data-toggle="validator" role="form" class="form-horizontal" method="POST"
                  @if(empty($check_front_account))
                  action="{{ route('orm::check-front-accounts::display.store') }}"
                  @else
                  action="{{ route('orm::check-front-accounts::display.update', ['check_front_account' => $check_front_account]) }}"
                    @endif
            >
                {!! method_field(((empty($check_front_account))? 'POST': 'PUT')) !!}
                {!! csrf_field() !!}
                @endslot

                @slot('formFields')

                    @component('fuqu-prototype-ui::forms._textInput')
                        @slot('name' , 'api')
                        @slot('type', 'url')
                        @slot('icon' , 'cloud')
                        @slot('default', ((!empty($check_front_account))? $check_front_account->api: null))
                        @slot('required', true)
                    @endcomponent

                    @component('fuqu-prototype-ui::forms._textInput')
                        @slot('name' , 'token')
                        @slot('type', 'text')
                        @slot('icon' , 'eye-open')
                        @slot('default', ((!empty($check_front_account))? $check_front_account->token: null))
                        @slot('required', true)
                    @endcomponent

                    @component('fuqu-prototype-ui::forms._textInput')
                        @slot('name' , 'secret')
                        @slot('type', 'password')
                        @slot('icon' , 'eye-close')
                        @slot('default', ((!empty($check_front_account))? $check_front_account->secret: null))
                        @slot('required', true)
                    @endcomponent

                @endslot

                @slot('formButtons')
                    <div class="text-center">
                        <div class="btn-group" role="group">
                            <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
                                {{ trans('fuqu-prototype-ui::short.submit') }}
                            </button>
                        </div>
                    </div>
                @endslot

                @slot('formClose')
            </form>
        </div>
    @endslot
@endcomponent