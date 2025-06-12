import React, { useState } from "react";
import { router } from "@inertiajs/react";

export default function ActionsList({conversionActions}) {
    console.log(conversionActions);
    const [actionsId, setActionsId] = useState({
        customer_id: "*****",
    });

    function handleChange(e) {
        const key = e.target.name;
        const value = e.target.value;
        setActionsId((prev) => ({
            ...prev,
            [key]: value,
        }));
    }

    function actions(e) {
        e.preventDefault();
        router.post("/sendApi/actions", actionsId);
    }

    return(
        <>
        <form onSubmit={actions}>
            <label className="mt-10 mb-5 flex justify-around items-center">
                <span className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    customer_id
                </span>
                <select
                    name="customer_id"
                    value={actionsId.customer_id}
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
                className="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mx-auto block dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900"
            >
                アクションを見る
            </button>
        </form>
        {conversionActions && (
            <div className="mt-4 p-4 bg-gray-100 rounded">
                <h2 className="text-lg font-bold">
                    アップロード結果
                </h2>
                <table className="w-9/12 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead>
                        <tr>
                            <th className="px-6 py-3">番号</th>
                            <th className="px-6 py-3">resource_name</th>
                            <th className="px-6 py-3">id</th>
                            <th className="px-6 py-3">name</th>
                            <th className="px-6 py-3">category</th>
                            <th className="px-6 py-3">type</th>
                            <th className="px-6 py-3">status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {conversionActions.map((response, index) => (
                            <tr key={response.id}>
                                <th className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {index}
                                </th>
                                <td className="px-6 py-4">
                                    {response.resource_name}
                                </td>
                                <td className="px-6 py-4">{response.id}</td>
                                <td className="px-6 py-4">
                                    {response.name}
                                </td>
                                <td className="px-6 py-4">
                                    {response.category}
                                </td>
                                <td className="px-6 py-4">
                                    {response.type}
                                </td>
                                <td className="px-6 py-4">
                                    {response.status}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        )}
    </>    )
}
