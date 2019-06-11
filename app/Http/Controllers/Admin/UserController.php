<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //1.获取提交的请求
        $users = User::orderBy('user_id', 'asc')->where(function ($query) use ($request) {
            $username = $request->input('username');
            $useremail = $request->input('useremail');
            $userphone = $request->input('userphone');
            if (!empty($username)) {
                $query->where('user_name', 'like', '%' . $username . '%');
            }
            if (!empty($useremail)) {
                $query->where('email', 'like', '%' . $useremail . '%');
            }
            if (!empty($userphone)) {
                $query->where('phone', 'like', '%' . $userphone . '%');
            }
        });
        //获取到列表页数据并计数
        $count_users = count($users->get());

        //使用laravel自带fen'ye分页类paginate(每页显示条数)
        $users = $users->paginate($request->input('number')?$request->input('number'):12);
        $i=1;
        return view('admin.user.list',compact('users','count_users','request','i'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1.接收前台表单提交的数据
        $input = $request->all();

        // 2.进行表单验证

        // 3.添加到数据库的user表
        $username = $input['username'];
        $userpass = Crypt::encrypt($input['userpass']);
        $useremail = $input['email'];
        $userphone = $input['phone'];
        $res = User::create(['user_name'=>$username, 'user_pass'=>$userpass, 'email'=>$useremail, 'phone'=>$userphone]);

        // 4.根据添加是否成功,给客户端返回一个json格式的反馈
        if ($res) {
            $data = [
                'status'=>0,
                'message'=>'添加成功'
            ];

        } else {
            $data = [
                'status'=>1,
                'message'=>'添加失败'
            ];
        }
        // laravel会自动将返回的数组转换为json格式字符串,类似json_encode($data);
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $user = User::find($id);
        if ($request->tag == 'edit') {
            return view('admin.user.edit', compact('user'));
        } else if ($request->tag == 'pass') {
            return view('admin.user.password', compact('user'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 1.根据id获取要修改的记录
        $user = User::find($id);

        // 2.根据获取到的标记判断执行修改个人信息或修改密码的操作
        $tag = $request->input('tag');

        if ($tag == 'edit') {
            // 3.获取要修改成的值
            $username = $request->input('username');
            $useremail = $request->input('email');
            $userphone = $request->input('phone');

            $user->user_name = $username;
            $user->email = $useremail;
            $user->phone = $userphone;

            $res = $user->save();
            if ($res) {
                $data = [
                    'status'=>0,
                    'message'=>'信息修改成功'
                ];
            } else {
                $data = [
                    'status'=>1,
                    'message'=>'信息修改失败'
                ];
            }
        } else if ($tag == 'pass') {
            // 3.获取要修改成的值
            if($request['oldpass'] != Crypt::decrypt($user->user_pass)) {
                $data = [
                    'status'=>1,
                    'message'=>'旧密码输入错误!'
                ];
            } else {
                $password = $request->input('newpass');
                $user->user_pass = Crypt::encrypt($password);

                $res = $user->save();
                if ($res) {
                    $data = [
                        'status'=>0,
                        'message'=>'密码修改成功'
                    ];
                } else {
                    $data = [
                        'status'=>1,
                        'message'=>'密码修改失败'
                    ];
                }
            }
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id == 1) {
            $data = [
                'status'=>1,
                'message'=>'至高无上的超级管理员不能被删除!'
            ];
            return $data;
        } elseif ($id == session('user')->user_id){
            $data = [
                'status'=>1,
                'message'=>'自己不能抹除自己~'
            ];
            return $data;
        }
        //通过传递的id查找用户,执行删除操作
        $user = User::find($id);
        $res = $user->delete();
        if ($res) {
            $data = [
                'status'=>0,
                'message'=>'删除成功!'
            ];
        } else {
            $data = [
                'status'=>1,
                'message'=>'删除失败!'
            ];
        }
        return $data;
    }

    // 删除选中的用户
    public function delAll(Request $request)
    {
        //获取要删除的多个用户的id,执行删除
        $input = $request->input('ids');
        if (in_array(1, $input)) {
            $data = [
                'status'=>1,
                'message'=>'至高无上的超级管理员不能被删除!'
            ];
            return $data;
        } elseif (in_array(session('user')->user_id, $input)) {
            $data = [
                'status'=>1,
                'message'=>'自己不能抹除自己~'
            ];
            return $data;
        }
        $res = User::destroy($input);
        if ($res) {
            $data = [
                'status'=>0,
                'message'=>'批量删除成功!'
            ];
        } else {
            $data = [
                'status'=>1,
                'message'=>'批量删除失败!'
            ];
        }
        return $data;
    }

    // 修改用户状态 1启用 0禁用 默认启用
    public function changeStatus(Request $request)
    {
        $userid = $request->input('id');
        $status = $request->input('status');

        $user = User::find($userid);
        $res = $user->update(['status'=>$status]);
        if ($res) {
            $data = [
                'status'=>0,
                'msg'=>'修改成功'
            ];
        } else {
            $data = [
                'status'=>1,
                'msg'=>'修改失败'
            ];
        }
        return $data;
    }
}
