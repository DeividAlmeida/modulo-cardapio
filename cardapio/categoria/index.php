<?php
$query = json_encode(DBRead('cardapio_categoria','*'));
$status = $_GET['Cat'];
$cod="<script src='https://cdn.jsdelivr.net/npm/vue@2'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.10.2/underscore-min.js'></script>
<div id='cardapio'></div>";
?>
<div class="card"  >
    <div id="control" v-if="!status">
        <div class="card-header white" >
            <strong>Adicionar Categoria</strong>
                <a class="adicionarListagemItem tooltips" data-tooltip="Adicionar" @click="move('0')" >
                    <i class="icon-plus blue lighten-2 avatar"></i> 
                </a>
        </div>
        <div class="card-body p-0" v-if="ctrls != false">
            <div>
                <div>
                    <table id="DataTable" class="table m-0 table-striped">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Implementação</th>
                            <th>Item</th>
                            <th width="53px">Ações</th>
                        </tr>
                        <tr>
                            <td>0</td>
                            <td>Todas as categorias</td>
                            <td>
                                <button id="btnCopiarCodSite0" class="btn btn-primary btn-xs m-1" onclick="CopiadoCodSite(0)"  data-clipboard-text="<?php  echo $cod?><script>$('#cardapio').load('<?php echo ConfigPainel('base_url') ?>wa/cardapio/')</script>" type="button">
                                    <i class="icon icon-code"></i> Copiar Cod. do Site 
                                </button>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr v-for="ctrl, index in ctrls">
                            <td>{{index+1}}</td>
                            <td>{{ctrl.nome}}</td>
                            <td>
                                <button :id="'btnCopiarCodSite'+ctrls[index].id" class="btn btn-primary btn-xs m-1" :idi="ctrls[index].id" onclick="CopiadoCodSite(getAttribute('idi'))"  :data-clipboard-text="'<script '+underscore+'></script><script '+vue+'></script><div '+div+'></div><script>'+codigo[index]+'</script>'" type="button">
                                    <i class="icon icon-code"></i> Copiar Cod. do Site
                                </button>
                            </td>
                            <td>
                                <a class="tooltips" data-tooltip="Adicionar" :href="'?Item=0&Catego='+ctrls[index].id">
                                    <i class="icon-plus blue lighten-2 avatar"></i>
                                </a>
                                    <a class="tooltips" data-tooltip="Visualizar" :href="'?Item&Catego='+ctrls[index].id"><i class="icon-eye blue lighten-2 avatar"></i>
                                </a>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a class="" href="#" data-toggle="dropdown">
                                        <i class="icon-apps blue lighten-2 avatar"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                        <?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'deletar')) { ?>
                                            <a class="dropdown-item"  @click="move(ctrl.id, index)" href="#!"><i class="text-primary icon icon-pencil" ></i> Editar</a>
                                        <?php } ?>
                                        <?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'deletar')) { ?>
                                            <a class="dropdown-item" :data-id="ctrl.id"  onclick="DeletarItem(getAttribute('data-id'), 'DeletarCategoria');" href="#!"><i class="text-danger icon icon-remove"></i> Excluir </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-body" v-else>
            <?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'adicionar')) { ?>
                <div class="alert alert-info">Nenhuma categoria adicionada a essa listagem até o momento, <a class="adicionarListagemItem" href="?Cat=0" >clique aqui</a> para adicionar.</div>
            <?php } ?>
        </div>
    </div>
    <div class="card-body" v-else>
        <form method="post" :action="'?C_id='+status" >
            <div class="row" v-if="status !=0">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Nome: </label>
                        <input class="form-control" v-model="ctrls[idx].nome" name="nome" required>
                    </div>
                    <div class="form-group">
                        <label>Descrição: </label>
                        <textarea class="form-control" v-model="ctrls[idx].descricao" name="descricao" required>{{ctrls[idx].descricao}}</textarea>
                    </div>
                </div>
            </div>
            <div class="row" v-if="status == 0">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Nome: </label>
                        <input class="form-control"  name="nome" required>
                    </div>
                    <div class="form-group">
                        <label>Descrição: </label>
                        <textarea class="form-control"  name="descricao" required></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer white">
                <button style="margin-bottom: 7px;" class="btn btn-primary float-right" type="submit"><i class="icon icon-save" aria-hidden="true"></i> Salvar</button>
            </div>
        </form>
    </div>
</div>
<script>
    const vue = new Vue({
        el:".card",
        data: {
            idx:"",
            status:"<?php echo $status ?>",
            ctrls:<?php echo $query ?>,
            vue:'src="https://cdn.jsdelivr.net/npm/vue@2"',
            underscore:'src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.10.2/underscore-min.js"',
            div:'id="cardapio"',
            codigo:[]
        },
        methods:{
            move: function(a, b){
                this.status = a;
                this.idx = b;
            }
        }
    })
    for(let i = 0; i < vue.ctrls.length; i++){
        vue.codigo.push("$('#cardapio').load('<?php echo ConfigPainel('base_url')?>wa/cardapio/?id="+vue.ctrls[i].id+"')")
    }
</script>