# ①課題番号-プロダクト名

9 - 看護記録アプリ

## ②課題内容（どんな作品か）

- 家族の体調不良時、いつもiPhoneのメモ帳にメモをつけていますが、様々なメモに紛れてしまって過去の記録を探すのが大変でした。アプリで記録・保存しやすいものを目指して作りました。
- 前回作成したものをデータベース化したのに加え、直近2日分の発熱がグラフで表示されるようにしました。

## ③DEMO

https://a57.sakura.ne.jp/kadai08_db1/index.php

## ④作ったアプリケーション用のIDまたはPasswordがある場合

- なし

## ⑤工夫した点・こだわった点

- グラフ表示を頑張りました！データをJSON形式で取得し、flotを使ってグラフに描画しています。
- 直近2日分のみがグラフで表示されるよう、グラフ側のmin/maxで調整しています。
- 入力時に日付と時間を別で取得してしまったので、JavaScriptで後から結合するのに手間取りました。

## ⑥難しかった点・次回トライしたいこと(又は機能)

- 検索機能をつけたいです。
- 記録を各体調不良時ごとにまとめて、過去に同じ病名だったときの記録を見返せるようにしたいです。どうデータ化すれば実現できるか、イメージが湧いていません。
  
## ⑦次回ミニ講義で聞きたいこと

- 

## ⑧フリー項目（感想、シェアしたいこと等なんでも）

- [感想]今回の反省点は、データの使用方法や表示方法をきちんと決めてからデータの項目を決めないと、使いづらいデータになってしまう点です（後から結合するのに手間取った…）。
- JSONデータを初めて使えたので嬉しいです。少しずつできることが増えて嬉しい一方で、企画を進めねばという焦りも大きくなってきました…！
