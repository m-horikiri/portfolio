import React, { useState } from "react";
import { router } from "@inertiajs/react";

export default function OfflineConversionUploaded({ offlineCvUploaded }) {
    const [customerId, setCustomerId] = useState({
        customer_id: "*****",
    });

    function handleChange(e) {
        const key = e.target.name;
        const value = e.target.value;
        setCustomerId((prev) => ({
            ...prev,
            [key]: value,
        }));
    }

    function dataSubmit(e) {
        e.preventDefault();
        router.post("/sendApi/offlineConversionUploaded", customerId);
    }

    return (
        <>
            <form onSubmit={dataSubmit}>
                <label className="mb-5 flex justify-around items-center">
                    <span className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        customer_id
                    </span>
                    <select
                        name="customer_id"
                        value={customerId.customer_id}
                        required={true}
                        onChange={handleChange}
                        className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-9/12 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    >
                        <option value="*****">PIA</option>
                        <option value="*****">MS</option>
                        <option value="*****">HIKAKU</option>
                    </select>
                </label>
                <button
                    type="submit"
                    className="mb-10 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mx-auto block dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900"
                >
                    OfflineConversionUploadClientSummary
                </button>
            </form>
            {offlineCvUploaded && (
                <div className="mt-4 p-4 bg-gray-100 rounded">
                    <h2 className="text-lg font-bold">
                        コンバージョンアクション一覧
                    </h2>
                    <table className="w-9/12 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead>
                            <tr>
                                <th className="px-6 py-3">index</th>
                                <th className="px-6 py-3">
                                    コンバージョン アクション ID
                                </th>
                                <th className="px-6 py-3">
                                    コンバージョン アクション名
                                </th>
                                <th className="px-6 py-3">合計イベント数</th>
                                <th className="px-6 py-3">成功イベント数</th>
                                <th className="px-6 py-3">保留中イベント数</th>
                                <th className="px-6 py-3">
                                    最終アップロード日時
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {offlineCvUploaded.map((response, index) => (
                                <tr key={index}>
                                    <th className="px-6 py-4">
                                        {index}
                                    </th>
                                    <td className="px-6 py-4">
                                        {response.actionId}
                                    </td>
                                    <td className="px-6 py-4">
                                        {response.actionName}
                                    </td>
                                    <td className="px-6 py-4">
                                        {response.totalEvent}
                                    </td>
                                    <td className="px-6 py-4">
                                        {response.successEvent}
                                    </td>
                                    <td className="px-6 py-4">
                                        {response.holdEvent}
                                    </td>
                                    <td className="px-6 py-4">
                                        {response.lastUploadDate}
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            )}
        </>
    );
}
