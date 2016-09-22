<?php

class BankController extends NodeController
{

    //支付提交入口
    public function pay()
    {
        $bank = new BankService ();
        $bank->pay($this->_user_global ['uid'], $_POST);
    }

    //充值成功后返回信息
    public function notify()
    {
        $this->view()->display('file:wallet/success.tpl');
    }


    public function bank()
    {
        $bankService = new BankService();
        $banks = $bankService->getBank();
        $this->view()->assign('bank', $banks);
        $this->view()->display("file:wallet/bank.tpl");
    }
}