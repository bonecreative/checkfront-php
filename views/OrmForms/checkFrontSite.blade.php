@component('fuqu-prototype-ui::forms.wrapperAuto')

    @if(!empty($unique))
        @slot('unique', $unique)
    @endif

    @slot('title', ((empty($check_front_site))? 'CheckFrontSite': $check_front_site->getKey()))

    @slot('formOpen')
        <div class="form">
            <form data-toggle="validator" role="form" class="form-horizontal" method="POST"
                  @if(empty($check_front_site))
                  action="{{ route('orm::check-front-sites::display.store', ['check_front_account'=> $check_front_account]) }}"
                  @else
                  action="{{ route('orm::check-front-sites::display.update', ['check_front_account'=> $check_front_account, 'check_front_site' => $check_front_site]) }}"
                    @endif
            >
                {!! method_field(((empty($check_front_site))? 'POST': 'PUT')) !!}
                {!! csrf_field() !!}
                @endslot

                @slot('formFields')

                    @component('fuqu-prototype-ui::forms._textInput')
                        @slot('name' , 'domain')
                        @slot('type', 'text')
                        @slot('default', ((!empty($check_front_site))? $check_front_site->domain: null))
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