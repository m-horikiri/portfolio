import React from "react";
import { router } from "@inertiajs/react";

export default function DataForm({ datas, onEdit }) {
    function daleteData(id) {
        router.delete(`/data/${id}/`);
    }
    return (
        <div className="my-10 relative overflow-x-auto">
            <table className="text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead>
                    <tr>
                        <th className="px-6 py-3">登録番号</th>
                        <th className="px-6 py-3">名前</th>
                        <th className="px-6 py-3">媒体名</th>
                        <th className="px-6 py-3">GCLID</th>
                        <th className="px-6 py-3">受付日時</th>
                        <th className="px-6 py-3"></th>
                        <th className="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    {datas?.map((data) => (
                        <tr key={data.id}>
                            <th className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {data.id}
                            </th>
                            <td className="px-6 py-4">{data.name}</td>
                            <td className="px-6 py-4">{data.media}</td>
                            <td className="px-6 py-4">{data.gclid}</td>
                            <td className="px-6 py-4">{data.acceptanceTime}</td>
                            <td className="px-6 py-4">
                                <button
                                    onClick={() => onEdit(data)}
                                    className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                >
                                    CV送信
                                </button>
                            </td>
                            <td className="px-6 py-4">
                                <button
                                    onClick={() => daleteData(data.id)}
                                    className="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                                >
                                    データ削除
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}
