{include file="buy/header.tpl"}

{literal}
    <style>
        body {
            min-height: 1200px;
        }

        <!--
        .table {
            font-size: 12px;
        }

        .table th {
            background: #E9E9E9
        }

        .banks {
            border-bottom: 1px dashed #c6d5ee;
            padding-bottom: 5px;
        }

        .radio {
            height: 40px;
            margin-right: 5px;
        }

        .check {
            margin-top: 10px;
        }

        .radio input[type="radio"], .checkbox input[type="checkbox"] {
            margin-top: 10px;
        }

        .controls > .radio:first-child, .controls > .checkbox:first-child {
            padding-top: 0px;
        }

        input[type="text"] {
            border: 1px #ccc solid;
            border-radius: 0px;
            color: #000;
            font-weight: 700
        }

        .balance {
            font-size: 14px;
            font-weight: 700;
            color: #598e00;
            line-height: 30px;
        }

        .zhanghu {
            border: 2px solid #bbcbef;
        }

        -->
    </style>
{/literal}

<!-- start: Content -->
<div class="span12">


    <div class="row-fluid">


        <div class="box span12"><!-- Default panel contents -->

            <form class="form-horizontal" method="post" onsubmit="return check()" style="margin-top: 50px;"
                  action="./index.php?bank/pay">


                <div class="control-group">
                    <label class="control-label" for="inputEmail">充值金额</label>

                    <div class="controls banks">
                        <input type="text" id="money1" class="input-small" name="money1" value="0"> 元
                        &nbsp;&nbsp;
                        <!--
                        其中划特价<input type="text" id="money2" class="input-small"  name="money2" value="0" disabled> 元
               -->
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="inputEmail">你的银行卡</label>

                    <div class="controls">
                        {foreach from=$bank item=l key=key}
                            <label class="radio pull-left" style="height:40px;">
                                <input type="radio" name="bankId" class="check" value="{$key}"><img
                                        src="./static/bootstrap2/ico/{$key}.png" class="bank_ico">
                            </label>
                        {/foreach}

                    </div>
                </div>
                <div class="hr"></div>

                <div class="control-group">
                    <label class="control-label" for="inputEmail">
                        充值说明

                    </label>

                    <div class="controls">

                        <table class="table table-bordered">
                            <tr>
                                <th>项目</th>
                                <th>备注</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>打款后，系统会在1小时以内确认完毕。</td>
                            </tr>


                            <tr>
                                <td>2</td>
                                <td>如需发票，请以公司网银至我公司即可。（请不要使用此通道打款）</td>
                            </tr>

                        </table>

                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label" for="inputEmail"></label>

                    <div class="controls">


                        <input type="submit" class="btn btn-warning" value="登陆到网上银行充值"> <span
                                style="color:red;font-size:12px;">注:如果点击之后没有弹出银行窗口，请看下方的图片</span>
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label" for="inputEmail"></label>

                    <div class="controls">

                        充值遇到问题？<br>
                        1、无法弹出银行窗口？<br>
                        答：请点击浏览器上方的按钮，<span style="color:red">点击不再拦截该网站。</span>如下图
                        <img src="http://www.d-shang.com/static/attached/image/201504/201504010850k3uy.jpg">
                        <br><br>
                        2、充值钱之后，如何查看是否充值成功？<br>
                        答：点击我们资金明细，可以查看是否充值成功。<br><br>
                        3、没有你的银行怎么办？<br>
                        答: 直接点击最后一个 银联支付就可以啦。
                        <br>
                        4、汇款方式<br>
                        名称：嘉兴移动科技有限公司<br>
                        开户行：交通银行股份有限公司嘉兴秀园支行<br>
                        账号：334606000018800000830<br>

                        <br>


                    </div>
                </div>
        </div>


    </div>
</div>
</form>

{literal}
    <script>
        function balance() {

            $("#balance").html("<img src='/static/bootstrap2/img/wait.gif'>");

            $.post("./index.php?buyaccount/balance", function (data) {
                if (data.status == true) {
                    $("#balance").html(data.data + "元")
                } else {

                    alert(data.message);
                }

            }, "json")

        }

        function check() {
            var money1 = $("input[name='money1']").val();
            var money2 = $("input[name='money2']").val();
            

            if (money1 < 1000) {
                alert("不能小于1000");
                return false;
            }


            var bank = $('input:radio[name="bankId"]:checked').val();
            if (bank == null) {

                alert("请选择银行");
                return false;
            }
            return true;
        }
        function isNumber(s) {
            var regu = "^[0-9]+$";
            var re = new RegExp(regu);
            if (s.search(re) != -1) {
                return true;
            }
            else {
                return false;
            }
        }
    </script>
{/literal}

