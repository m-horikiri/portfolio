import { useState } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import {
  faWandMagicSparkles,
  faShareFromSquare,
} from '@fortawesome/free-solid-svg-icons';
import { motion, AnimatePresence } from 'framer-motion';

import php01 from '../assets/works/php01.png';
import php02 from '../assets/works/php02.png';
import wordPress01 from '../assets/works/wordPress01.png';
import wordPress02 from '../assets/works/wordPress02.png';
import wordPress03 from '../assets/works/wordPress03.png';
import wordPress04 from '../assets/works/wordPress04.png';
import wordPress05 from '../assets/works/wordPress05.png';
import wordPress06 from '../assets/works/wordPress06.png';
import others01 from '../assets/works/others01.png';
import others02 from '../assets/works/others02.png';
import others03 from '../assets/works/others03.png';

type WorkItem = {
  label: string;
  img: string;
  text: string;
  url?: string;
  gitUrl?: string;
};

export default function Works() {
  const [selectedItem, setSelectedItem] = useState<WorkItem | null>(null);

  const categories = [
    {
      title: 'PHP',
      items: [
        {
          label: 'フォームのAPIエンドポイント化',
          img: php01,
          text: 'フォーム送信時の自動メール送信の仕組みをAPIエンドポイント形式に変更。変更前は運用しているフォームごとにPHPMailerをインストールする必要があり、バリデーションもまともに行われていなかった為、保守性や安全性に欠けていた。エンドポイント形式にすることで、フォームを一本化することに成功した他、細やかなバリデーションや変数の.envファイル化により安全性・保守性を向上させた。',
          url: 'https://www.clairvoyancecorp.com/form/v3/',
          gitUrl: 'https://github.com/m-horikiri/portfolio/tree/main/form',
        },
        {
          label: 'Google広告API連携',
          img: php02,
          text: '既存のシステムとGoogle広告APIを連携させるプロジェクトにて、デモコードの作成を担当。既存システムの仕様で分かっている情報が「PHPを使っている」ことのみだったが、Dockerを用いて開発環境を1から構築し、可能な限りそのまま組み込めるであろうコードを作成。Google広告APIのリファレンスを詳細に読み込み、仕様について共有する資料も作成した。',
          gitUrl: 'https://github.com/m-horikiri/portfolio/tree/main/googleApi',
        },
      ],
    },
    {
      title: 'WordPress',
      items: [
        {
          label: 'KIRARI Pharmacy株式会社 公式サイト',
          img: wordPress01,
          text: 'ペライチで作成していたサイトをWordPress化。WordPress導入・テーマ構築を担当。カスタム投稿タイプとカスタムフィールドを設定し、クライアント側でも容易に更新できるよう設定した。',
          url: 'https://kirari-ph.co.jp/',
          gitUrl:
            'https://github.com/m-horikiri/portfolio/tree/main/kirariPharmacy',
        },
        {
          label: '株式会社PIA 公式サイト',
          img: wordPress02,
          text: 'コーポレートサイトにコラムサイトを合体するプロジェクトにて、WordPressの移植・テーマ構築を担当。目次やページャーなどのパーツは自作し、細かなカスタマイズを実現した。更新の可能性が高いページの殆どをWordPress上で変更できるように構築した為、SEOマーケターが自由に更新可能。',
          url: 'https://www.pi-a.jp/',
          gitUrl: 'https://github.com/m-horikiri/portfolio/tree/main/pia',
        },
        {
          label: 'MSクリニック横浜 公式サイトコラムページ',
          img: wordPress03,
          text: '既存の静的サイトにWordPressでコラムページを追加するプロジェクトにて、WordPress導入・テーマ構築を担当。外部のライターが自由に投稿・編集できるように構築。',
          url: 'https://www.ipsos-reid.com/column/',
          gitUrl:
            'https://github.com/m-horikiri/portfolio/tree/main/msYokohama',
        },
        {
          label: '桂屋ファイングッズ ECサイト検索機能追加',
          img: wordPress04,
          text: 'Welcartで構成されているECサイトの商品絞り込み機能を追加。このサイト自体は他にも多数のカスタマイズを実施。テーマの構築自体は他社が行っており、独自のカスタマイズ等が散見される中で、できるだけクライアントの要望に応えられるように尽力した。',
          url: 'https://www.katsuraya-fg.com/onlineshop/',
          gitUrl: 'https://github.com/m-horikiri/portfolio/tree/main/katsuraya',
        },
        {
          label: '株式会社クレアテラ EC機能追加',
          img: wordPress05,
          text: '既存WordPressサイトにWelcartを追加することでEC機能を追加。デザインからWelcart導入・カスタマイズの全てを担当。既存のテーマに影響を及ぼさないよう子テーマで開発し、Welcartの機能も必要なものだけに絞り込んで実装した。',
          url: 'https://createrra.co.jp/createrrashop/',
          gitUrl:
            'https://github.com/m-horikiri/portfolio/tree/main/createrra/',
        },
        {
          label: '有限会社ケニックシステム 公式サイト',
          img: wordPress06,
          text: '既存サイトのフルリニューアルプロジェクトにて、デザインからテーマ構築まで担当。このプロジェクトでは要件定義フェーズから参加しており顧客折衝を経験。リニューアル前は情報への導線が雑然としており問い合わせ対応に追われていたが、リニューアル後に改善した。',
          url: 'https://www.kenic.co.jp/',
        },
      ],
    },
    {
      title: 'Others',
      items: [
        {
          label: 'MSクリニック 公式サイト',
          img: others01,
          text: '既存サイトのフルリニューアル、ページ追加・修正、各種機能追加（目次・離脱ポップアップなど）等を包括的に担当。元は画像メインのサイトだったが、他メンバーが変更しやすい形を目指し、テキスト化と適切なマークアップへの修正作業を一人で行った。',
          url: 'https://www.clairvoyancecorp.com/',
        },
        {
          label: 'MSクリニック 大宮院サイト',
          img: others02,
          text: '新規開院に伴うサイト制作プロジェクトにて、コーディングを担当。',
          url: 'https://www.msclinic.or.jp/',
        },
        {
          label: '株式会社メイクス LP',
          img: others03,
          text: '広告出稿用のLPをデザイン・コーディング。学生向けのデザインを強く意識し、クライアントにも大変評価いただいた。',
          url: 'https://emi-more.com/lp/class_tshirts',
          gitUrl: 'https://github.com/m-horikiri/portfolio/tree/main/maksLp',
        },
      ],
    },
  ];

  return (
    <div className="py-10 bg-slate-50">
      <div className="max-w-6xl mx-auto px-6">
        <h2 className="text-3xl font-bold text-indigo-600 text-center mb-10">
          <FontAwesomeIcon icon={faWandMagicSparkles} className="mr-2" />
          Works
        </h2>

        {categories.map((category) => (
          <div key={category.title} className="mb-8">
            <h3 className="text-xl font-semibold text-indigo-500 mb-4 border-b pb-1">
              {category.title}
            </h3>
            <ul className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
              {category.items.map((item) => (
                <li
                  key={item.label}
                  onClick={() => setSelectedItem(item)}
                  className="cursor-pointer group"
                >
                  <div className="rounded-lg overflow-hidden shadow-lg bg-white hover:shadow-xl transition">
                    <img
                      src={item.img}
                      alt={item.label}
                      className="w-full h-48 object-cover group-hover:scale-105 transition duration-300"
                    />
                    <div className="p-4">
                      <h4 className="text-lg font-semibold">{item.label}</h4>
                    </div>
                  </div>
                </li>
              ))}
            </ul>
          </div>
        ))}

        {/* モーダル */}
        <AnimatePresence>
          {selectedItem && (
            <motion.div
              className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
              onClick={() => setSelectedItem(null)} // 背景クリックで閉じる
            >
              <motion.div
                className="bg-white max-w-2xl w-full p-6 rounded-xl shadow-lg relative z-10"
                initial={{ scale: 0.8, opacity: 0 }}
                animate={{ scale: 1, opacity: 1 }}
                exit={{ scale: 0.8, opacity: 0 }}
                onClick={(e) => e.stopPropagation()} // 中身クリックで閉じない
              >
                <button
                  onClick={() => setSelectedItem(null)}
                  className="absolute top-2 right-4 text-gray-500 hover:text-gray-800 text-xl"
                >
                  &times;
                </button>
                <h4 className="text-xl font-bold mb-4">{selectedItem.label}</h4>
                <img
                  src={selectedItem.img}
                  alt={selectedItem.label}
                  className="mb-4 rounded"
                />
                <p className="text-gray-700 mb-4">{selectedItem.text}</p>
                {selectedItem.url && (
                  <a
                    href={selectedItem.url}
                    target="_blank"
                    className="text-white bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800 hover:bg-gradient-to-br font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-5"
                  >
                    サイトを見る
                    <FontAwesomeIcon
                      icon={faShareFromSquare}
                      className="ml-2"
                    />
                  </a>
                )}
                {selectedItem.gitUrl && (
                  <a
                    href={selectedItem.gitUrl}
                    target="_blank"
                    className="text-white bg-gradient-to-r from-indigo-600 via-indigo-700 to-indigo-800 hover:bg-gradient-to-br font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                  >
                    GitHubのソースコード
                    <FontAwesomeIcon
                      icon={faShareFromSquare}
                      className="ml-2"
                    />
                  </a>
                )}
              </motion.div>
            </motion.div>
          )}
        </AnimatePresence>
      </div>
    </div>
  );
}
