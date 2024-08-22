@extends('layouts.app', ['page' => __('Создать пользователя'), 'pageSlug' => 'create users'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Создание Пользователя</h5>
            </div>
            <form method="post" action="{{route('create.new.users')}}" autocomplete="off">
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label>Hash ID</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                <i class="tim-icons icon-single-02"></i>
                            </div>          
                        </div>
                        <input type="text" name="hash_id" class="form-control" value="{{$hash_id}}" style="pointer-events: none;">
                    </div>

                    <div class="form-group">
                        <label>Пароль</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>          
                            </div>
                            <input type="text" name="password" class="form-control" placeholder="введите пароль" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Выбрать роль</label>
                        <select class="form-control" id="role" name="role">
                            @if(Auth::user()->hasRole('admin'))
                            <option value="client">Клиент</option>
                            <option value="agent">Куратор</option>
                            <option value="market">Обменник</option>
                            <option value="support">Поддержка</option>
                            @elseif(Auth::user()->hasRole('agent'))
                            <option value="market">Обменник</option>
                            @endif
                        </select>
                    </div>

                    <div id="unsupport">
                    
                        <div class="form-group">
                            <label>Реквезиты пополнения</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>          
                                </div>
                                <input type="text" name="details_from" class="form-control" placeholder="введите реквезиты пополнения" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Реквезиты получения </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>          
                                </div>
                                <input type="text" name="details_to" class="form-control" placeholder="введите реквезиты получения" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Приватный ключ реквезитов пополнения</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>          
                                </div>
                                <input type="text" name="private_key" class="form-control" placeholder="введите приватый ключ" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Баланс</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>          
                                </div>
                                <input type="text" name="balance" class="form-control" placeholder="введите баланс для пользователя">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Процент</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>          
                                </div>
                                <input type="text" name="percent" class="form-control" placeholder="введите процент для пользователя" requiredd>
                            </div>
                        </div>

                        <div class="form-group" id="market" >
                            <label for="exampleFormControlSelect1">Выбор куратора</label>
                            <select class="form-control" name="agent_id">
                                @foreach($agents as $agent)
                                    <option value="{{$agent->hash_id}}">{{$agent->hash_id}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">Создать</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const role = document.getElementById('role');
        const market = document.getElementById('market');
        const support = document.getElementById('unsupport')

        role.addEventListener('change', function(){
            const selectedRole = role.value;

            market.style.display = 'none';

            // Показываем секцию в зависимости от выбранной роли
            if (selectedRole === 'client') {
                market.style.display = 'none';
                support.style.display = 'block'
            } else if (selectedRole === 'market') {
                market.style.display = 'block';
                support.style.display = 'block'
            } else if (selectedRole === 'agent') {
                market.style.display = 'none';
                support.style.display = 'block'
            } else if (selectedRole === 'support'){
                support.style.display = 'none'
            }
        });

        role.dispatchEvent(new Event('change'))
    })
</script>

@endsection