<?php

define('_MD_PAYPAL_MODULE_TITLE', 'PayPal Payment');
define('_MD_PAYPAL_RECEIPT', 'クレジットご利用明細');
define('_MD_PAYPAL_TABLE_STATUS', '備考');
define('_MD_PAYPAL_TABLE_STATUS_0', 'カートの中身');
define('_MD_PAYPAL_TABLE_STATUS_1', '注文中の商品');
define('_MD_PAYPAL_TABLE_STATUS_2', '配送中の商品');
define('_MD_PAYPAL_TABLE_STATUS_3', '購入済の商品');
define('_MD_PAYPAL_TABLE_TITLE', '件名');
define('_MD_PAYPAL_TABLE_DATE', '日時');
define('_MD_PAYPAL_TABLE_UPDATE', '更新する');
define('_MD_PAYPAL_TABLE_CLOSE', '閉じる');
define('_MD_PAYPAL_RETURN_URL', 'チェックアウト画面へ戻る');
define('_MD_PAYPAL_DIALOG_DELETE', 'レコード削除');
define('_MD_PAYPAL_DIALOG_DELETE_DESC', 'このレコードを削除してもよろしいですか？');

//action form
define('_MD_PAYPAL_ERROR_REQUIRED', '入力必須項目エラー');
define('_MD_PAYPAL_ID', '決済ID');

// cart.html
define('_MD_PAYPAL_CART_INDEX', 'ショッピングカート');
define('_MD_PAYPAL_CART_ITEMID', '商品番号');
define('_MD_PAYPAL_CART_CONTENT', '商品名等');
define('_MD_PAYPAL_CART_PRICE', '価格');
define('_MD_PAYPAL_CART_QTY', '数量');


define('_MD_PAYPAL_MOVE_TO_PAYPAL','PayPal決済準備完了');
define('_MD_PAYPAL_MOVE_TO_PAYPAL_DESC','PayPalアカウント決済の準備ができました。リンクをクリックしてPayPalサイトへ移動してください。');
define('_MD_PAYPAL_TITLE_CARD_PAYMENT'  ,'クレジットカードでのお支払い');
define('_MD_PAYPAL_DESC_CARD_PAYMENT'  ,'お支払い金額をPayPalにて即時決済します。カード情報を入力し支払い実行をクリックしてください。');
define('_MD_PAYPAL_CARD_PAYMENT'  ,'支払い実行');
define('_MD_PAYPAL_PAYMENT_HISTORY','決済履歴');
define('_MD_PAYPAL_TITLE_SAVECARD'  ,'クレジットカード登録');
define('_MD_PAYPAL_TITLE_ADDCARD'  ,'クレジットカード登録');
define('_MD_PAYPAL_PROCEED_TO_ADDCARD'  ,'ご利用登録が済んでいますので、クレジットカード登録へお進みください。');

define('_MD_PAYPAL_TITLE_SEARCHCARD'  ,'登録カード検索');
define('_MD_PAYPAL_TITLE_ENTRYTRAN' ,'クレジットカードによるお支払い');
define('_MD_PAYPAL_TITLE_EXECTRAN'  ,'決済実行');
define('_MD_PAYPAL_SUBMIT_REGISTRATION','同意してアカウントを作成する');
define('_MD_PAYPAL_DESC_SAVECARD'  ,'PayPal に貴方のIDでクレジットカード情報を登録します。必要事項をご記入し登録をクリックしてください。');
define('_MD_PAYPAL_DESC_SEARCHCARD','PayPal に貴方のIDで登録したクレジットカード情報を検索します。必要事項をご記入し登録をクリックしてください。');
define('_MD_PAYPAL_DESC_ENTRYTRAN' ,'PayPal にてお支払いを行います。よろしければ「支払いを確定する」をクリックしてください。');
define('_MD_PAYPAL_DESC_EXECTRAN'  ,'PayPal へのお支払い方法と回数をご指定ください。以上でで決済完了です。');
define('_MD_PAYPAL_DONE_MEMBERSAVE','PayPal に貴方のIDでアカウントを作成しました。');
define('_MD_PAYPAL_DONE_SAVECARD'  ,'PayPal に貴方のIDでクレジットカード情報を登録しました。');
define('_MD_PAYPAL_DONE_SEARCHCARD','PayPal に貴方のIDで登録したクレジットカード情報を表示します。');
define('_MD_PAYPAL_DONE_ENTRYTRAN' ,'PayPal にてお支払いの受付が完了しました。取引完了まで以下のテキストを大切に保管して下さい。');
define('_MD_PAYPAL_DONE_EXECTRAN'  ,'PayPal にてお支払いが完了しました。');
define('_MD_PAYPAL_DONE_CANCELLED'   ,'PayPal のお支払いがキャンセルされました。取引を停止しました。');

// payment history
define('_MD_PAYPAL_UID','ユーザーID');
define('_MD_PAYPAL_CURRENCY','決済通貨');
define('_MD_PAYPAL_STATE','状態');
define('_MD_PAYPAL_UTIME','更新日時');

//SaveCard
define('_MD_PAYPAL_MEMBERID','会員ID');			// XOOPSのUID
define('_MD_PAYPAL_CARDSEQ','No.');		// クレジットカード複数毎指定時の選択
define('_MD_PAYPAL_SEQMODE','カード連番モード');	// 論理連番(デフォルト）か物理連番
define('_MD_PAYPAL_EXPIRE','カード有効期限');
define('_MD_PAYPAL_MONTH','月');
define('_MD_PAYPAL_YEAR','年');
define('_MD_PAYPAL_CARDNO','カード番号');
define('_MD_PAYPAL_CVV2','カード確認番号(裏面3桁、4桁)');
define('_MD_PAYPAL_CARDPASS','カードパスワード');	// PIN
define('_MD_PAYPAL_CARDNAME','カード種別(visa,master)');	// VISA,Master等
define('_MD_PAYPAL_HOLDERNAME','カード名義人');
define('_MD_PAYPAL_FIRSTNAME','名(First name)');
define('_MD_PAYPAL_LASTNAME','姓(Last name)');
define('_MD_PAYPAL_DEFAULTFLAG','通常使うカードに指定');
define('_MD_PAYPAL_RESISTER','カード情報を登録');
define('_MD_PAYPAL_SUBMIT','支払いを確定する');
define('_MD_PAYPAL_DO','する');
define('_MD_PAYPAL_DONOT','しない');
define('_MD_PAYPAL_SECMODE0','論理');
define('_MD_PAYPAL_SECMODE1','物理');
//EntryTran
define('_MD_PAYPAL_ORDERID','注文番号');
define('_MD_PAYPAL_JOBCD','処理区分');
define('_MD_PAYPAL_JOBCD_AUTH','AUTH:仮売上');
define('_MD_PAYPAL_JOBCD_CHECK','CHECK:有効性チェック');
define('_MD_PAYPAL_JOBCD_CAPTURE','CAPTURE:即時売上');
define('_MD_PAYPAL_ITEMCODE','商品コード');
define('_MD_PAYPAL_TAX','税送料');
define('_MD_PAYPAL_TDFLAG','3D利用');
define('_MD_PAYPAL_TDFLAG_SECURE','利用する');
define('_MD_PAYPAL_TDFLAG_NOSECURE','利用しない');
define('_MD_PAYPAL_TDTENANTNAME','3D認証画面店舗名');
//ExecTran
define('_MD_PAYPAL_ACCESSID','取引ID');
define('_MD_PAYPAL_HOLD','商品発送時決済予約中');
define('_MD_PAYPAL_DONETRAN','お支払い済み');
define('_MD_PAYPAL_ACCESSPASS','取引パスワード');
define('_MD_PAYPAL_PAYMETHOD','支払方法');
define('_MD_PAYPAL_PAYMETHOD1','1:一括');
define('_MD_PAYPAL_PAYMETHOD2','2:分割');
define('_MD_PAYPAL_PAYMETHOD3','3:ボーナス一括');
define('_MD_PAYPAL_PAYMETHOD4','4:ボーナス分割');
define('_MD_PAYPAL_PAYMETHOD5','5:リボ');
define('_MD_PAYPAL_PAYTIMES','支払回数');
define('_MD_PAYPAL_CLIENTFIELD1','加盟店自由項目１');
define('_MD_PAYPAL_CLIENTFIELD2','加盟店自由項目２');
define('_MD_PAYPAL_CLIENTFIELD3','加盟店自由項目３');

//BmPayPal
define('_MD_PAYPAL_PAY_BY_PAYPAL','PayPalアカウントによるお支払い');
define('_MD_PAYPAL_PAY_BY_PAYPAL_DSEC','当サイトからPayPalサイトへ移動してお支払い頂き、確定後当サイトへ戻ります。');
define('_MD_PAYPAL_AMOUNT','支払い金額(USD)');
define('_MD_PAYPAL_ORDER_ID','注文番号：');
