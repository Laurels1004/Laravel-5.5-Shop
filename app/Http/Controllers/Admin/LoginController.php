<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //返回后台登录页
    public function login()
    {
        return view('admin.login');
    }

    //第三方组件的验证码生成
    public function captcha($tmp)
    {
        $phrase = new PhraseBuilder;
        // 设置验证码位数
        $code = $phrase->build(4);
        // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色
        $builder->setBackgroundColor(220, 210, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        // 可以设置图片宽高及字体
        $builder->build($width = 120, $height = 48, $font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // 把内容存入session闪存
        \Session::flash('code', $phrase);
        // 生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }

    //处理管理用户登录
    public function doLogin(Request $request)
    {
        // 1.接收表单提交的数据
        $input = $request->except('_token');

        //2.使用Validator进行表单验证
        //2.1定义表单验证内置规则
        $rule = [
            'username' => 'required|between:4,18',
            'password' => 'required|between:4,18|alpha_dash'
        ];

        //2.2自定义表单验证错误时的输出
        $msg = [
            'username.required'=>'必须输入用户名',
            'username.between'=>'用户名长度必须在4~18位之间',
            'password.required'=>'必须输入密码',
            'password.between'=>'密码长度必须在4~18位之间',
            'password.alpha_dash'=>'密码必须是数字字母下划线',
        ];

        //2.3生成表单验证
        $validator = Validator::make($input, $rule, $msg);

        if ($validator->fails()) {
            return redirect('admin/login')
                ->withErrors($validator)
                ->withInput();
        }

        // 验证码生成之后保存在session中
        // pull 方法将会通过一条语句从 Session 获取并删除数据
        if (strtoupper($input['code']) !== strtoupper(session()->pull('code', 'default'))) {
            return redirect('admin/login')->with('errors', '验证码错误!');
        }

        // 3.验证是否有此用户(用户名 密码 验证码)
        $user = User::where('user_name', $input['username'])->first();

        if (!$user) {
            return redirect('admin/login')->with('errors', '该用户不存在!');
        } elseif ($input['password'] != Crypt::decrypt($user->user_pass)) {
            return redirect('admin/login')->with('errors', '用户密码错误!');
        } elseif ($user->status == 0) {
            return redirect('admin/login')->with('errors', '该用户未启用!');
        }

        // 4.保存用户信息到session
        session()->put('user', $user);

        // 5.跳转到后台首页
        return redirect('admin/index');
    }

    //后台首页
    public function index(){
        return view('admin.index');
    }

    //后台欢迎页
    public function welcome(){
        return view('admin.welcome');
    }


    //后台管理用户注销
    public function logout(){
        //清空session中用户信息后进行页面跳转
        session()->flush();
        return redirect('admin/login');
    }
}
