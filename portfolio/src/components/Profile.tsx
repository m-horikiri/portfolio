import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faFaceSmile } from '@fortawesome/free-solid-svg-icons';
import avatar from '../assets/avatar.png';

export default function Profile() {
  return (
    <div className="py-10 bg-purple-50">
      <div className="w-11/12 max-w-3xl mx-auto bg-white rounded-2xl shadow-md p-8">
        <div className="flex justify-center mb-6">
          <img
            src={avatar}
            alt="堀切 茉由"
            className="w-32 h-32 rounded-full shadow-lg border-4 border-purple-200 object-cover"
          />
        </div>

        <h2 className="text-2xl font-bold text-purple-600 mb-6 border-b-2 border-purple-200 pb-2 text-center">
          <FontAwesomeIcon icon={faFaceSmile} className="mr-2" />
          プロフィール
        </h2>

        <dl className="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-gray-700">
          <div>
            <dt className="font-semibold text-purple-500">名前</dt>
            <dd className="mt-1 text-lg">堀切 茉由</dd>
          </div>
          <div>
            <dt className="font-semibold text-purple-500">職業</dt>
            <dd className="mt-1 text-lg">フロントエンドエンジニア</dd>
          </div>
          <div>
            <dt className="font-semibold text-purple-500">誕生日</dt>
            <dd className="mt-1 text-lg">1998/02/26</dd>
          </div>
          <div>
            <dt className="font-semibold text-purple-500">モットー</dt>
            <dd className="mt-1 text-lg">その場限りでしか使えないコードを書かない</dd>
          </div>
        </dl>
      </div>
    </div>
  );
}
