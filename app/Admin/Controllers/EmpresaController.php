<?php

namespace App\Admin\Controllers;

use App\EmpresaModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class EmpresaController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new EmpresaModel);

        $grid->e_id('企业id');
        $grid->e_name('企业名称');
        $grid->e_corpo('法人');
        $grid->e_impuesto('税务号');
        $grid->e_bcard('对公账号');
        $grid->e_licencia('营业执照')->image();
        $grid->uid('用户ID');
        $grid->add_time('添加时间');
        $grid->app_id('App id');
        $grid->app_key('App key');
        $states = [
            'on'  => ['value' => 1, 'text' => '打开', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '关闭', 'color' => 'default'],
        ];
        $grid->e_status('审核状态')->switch($states);
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(EmpresaModel::findOrFail($id));

        $show->e_id('E id');
        $show->e_name('E name');
        $show->e_corpo('E corpo');
        $show->e_impuesto('E impuesto');
        $show->e_bcard('E bcard');
        $show->e_licencia('E licencia');
        $show->app_id('App id');
        $show->app_key('App key');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new EmpresaModel);

        $form->text('e_name', 'E name');
        $form->text('e_corpo', 'E corpo');
        $form->text('e_impuesto', 'E impuesto');
        $form->text('e_bcard', 'E bcard');
        $form->image('e_licencia', 'E licencia');
        $form->number('uid', 'Uid');
        $form->number('add_time', 'Add time');
        $form->text('app_id', 'App id');
        $form->text('app_key', 'App key');
        $states = [
            'on'  => ['value' => 1, 'text' => '打开', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '关闭', 'color' => 'default'],
        ];
        $form->switch('e_status','审核状态')->states($states);
        return $form;
    }
    public function update($id,Request $request)
    {
        $e_status=$request->input('e_status');
        if($e_status=='on'){
            $status=1;
            $app_id=str::random(16);
            $app_key=str::random(24);
            $data=[
                'e_status'=>$status,
                'app_id'=>$app_id,
                'app_key'=>$app_key
            ];
            //DB::connection()->enableQueryLog();
            $res=EmpresaModel::where(['e_id'=>$id])->update($data);
            //var_dump(DB::getQueryLog());
        }
    }
}
