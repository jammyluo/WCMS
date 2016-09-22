{include file="buy/header.tpl"}
<link href="./static/bootstrap2/css/wallet.css" rel="stylesheet"
      media="screen">
{literal}
    <style>
        .balance {
            font-size: 24px;
            color: #e4393c;
            font-family: verdana;
            font-weight: 700;
        }
    </style>
{/literal}

<div class="ui-border mr-t30">
    <div class="ui-block ui-block-line fn-clear">
        <div class="account-info ">
            <div style="width:100px;padding-left:20px;float:left;">
                <img
                        src="{if $user.face==null}./static/attached/face/default_01.jpg{else}{$user.face}{/if}"
                        id="J-portrait-user" alt="头像" width="66" height="66">
            </div>
            <div style="width:500px;float:left;">

                <ul class="account-info-det">
                    <li class="fn-clear firstLi fn-clear"><span class="fn-left">开户名：</span>
                        <span class="ui-list-text fn-left" title="{$user.real_name}">{$user.real_name}</span> <span
                                class="ui-list-img fn-left"> <a
                                    href="javascript:void(0)" target="_blank"
                                    title="会员等级：金账户" seed="firstLi-link" smartracker="on"> <img
                                        src="./static/bootstrap2/ico/ico-vip.gif" alt="会员等级：金账户"> </a>
	</span>


                    </li>

                    <li class=" fn-clear" style="padding-top: 10px;">

                        <span class="balance"> ￥{$wallet.money1+$wallet.money2+$wallet.discount|string_format:"%.2f"}</span>

                        <a href="./index.php?buyaccount/finance">收支明细</a> | <a href="?buyorderinfo/nodeliver">未发货明细</a>
                        | <a href="./index.php?wallet/bank">在线充值</a>
                    </li>
                    <li class=" fn-clear"><span class="fn-left">正价：</span> {$wallet.money1}</li>
                    <li class=" fn-clear"><span class="fn-left">特价：</span> {$wallet.money2}</li>

                    <li class=" fn-clear"><span class="fn-left">折扣：</span> {$wallet.discount}</li>


                    <li><span>安全等级：</span> <a class="userInfo-securelevel-high"
                                              href="https://securitycenter.alipay.com/sc/index.htm"
                                              seed="asset-safety-high-myalipay" target="_blank"> <i
                                    class="icon"></i>高</a>


                        <i
                                class="sbsType-icon-machine j-atip"
                                seed="security-icon-machine-myalipay" data-content="安全无忧"

                                data-content-link-text="管理"></i></li>


                </ul>

            </div>
        </div>
    </div>
    <!-- //ui-block -->


    <ul class="account-status fn-clear" id="J_used_pro">
        <li class="account-status-item account-status-authen">
            <div class="account-status-img  ico-authen"></div>
            <div class="account-status-det">
                <h4 class="tit">实名认证</h4>

                <p class="descript"><i class=" descript-icon  fn-left"></i> <span
                            class="fn-left">已认证</span></p>
            </div>
            <p class="account-status-info">您已享有顶上订购和充值服务</p>
        </li>
        <li class="account-status-item account-status-certify">
            <div class="account-status-img  ico-safeguard "></div>
            <div class="account-status-det">
                <h4 class="tit">会员保障</h4>

                <p class="descript"><i class=" descript-icon  fn-left"></i> <span
                            class="fn-left">已保障</span></p>
            </div>
            <p class="account-status-info account-status-infoB">您可享受会员保障服务</p>
        </li>
        <li class="account-status-item account-status-mobile">
            <div class="account-status-img  ico-mobile"></div>
            <div class="account-status-det">
                <h4 class="tit">手机 <span class="mobile-number">( {$user.mobile_phone})</span></h4>

                <p class="descript"><i class=" descript-icon  fn-left"></i> <span
                            class="fn-left">已绑定</span></p>
            </div>
            <p class="account-status-info account-status-infoP">您可享有手机相关的服务</p>
        </li>
    </ul>
</div>