# Woo Alipay Subscriptions

Woo Alipay 的订阅扩展插件，与 WooCommerce Subscriptions 集成，支持手动续费增强并预留自动代扣（签约/代扣）能力。

## 功能特性

- 与 WooCommerce Subscriptions 无缝集成
- 支持支付宝订阅支付
- 手动续费增强功能
- 预留自动代扣签约能力
- 完整的管理后台设置
- 邮件通知增强

## 依赖要求

- WordPress
- WooCommerce
- WooCommerce Subscriptions
- Woo Alipay 核心插件

## 安装方法

1. 将插件文件上传到 `/wp-content/plugins/woo-alipay-subscriptions/` 目录
2. 在 WordPress 管理后台激活插件
3. 确保已安装并启用所有依赖插件

## 文件结构

```
woo-alipay-subscriptions/
├── woo-alipay-subscriptions.php   # 主插件文件
├── inc/                           # 核心功能类
│   ├── class-wc-alipay-subscriptions.php           # 订阅集成主类
│   ├── class-wc-alipay-subscriptions-admin.php     # 管理后台设置
│   ├── class-wc-alipay-subscriptions-signing.php   # 签约路由
│   ├── class-wc-alipay-subscriptions-charge.php    # 收费助手
│   ├── class-wc-alipay-subscriptions-checkout.php  # 结账拦截器
│   ├── class-wc-alipay-subscriptions-emails.php    # 邮件增强
│   └── class-wc-payment-token-alipay-agreement.php # 支付宝协议支付令牌
└── languages/                     # 语言文件目录
```

## 版本信息

- 版本：0.1.0
- 作者：WooCN.com
- 官网：https://woocn.com/

## 许可证

请参考插件主文件中的许可证信息。