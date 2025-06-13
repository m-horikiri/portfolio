import React from "react";

export default function DataTable({ uploadeds, onEdit }) {
    return (
        <div className="relative overflow-x-auto">
            <table className="w-9/12 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead>
                    <tr>
                        <th className="px-6 py-3"></th>
                        <th className="px-6 py-3">status</th>
                        <th className="px-6 py-3">validate_only</th>
                        <th className="px-6 py-3">name</th>
                        <th className="px-6 py-3">customer_id</th>
                        <th className="px-6 py-3">gclid</th>
                        <th className="px-6 py-3">conversion_action_id</th>
                        <th className="px-6 py-3">conversion_date_time</th>
                        <th className="px-6 py-3">conversion_value</th>
                        <th className="px-6 py-3">order_id</th>
                        <th className="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    {uploadeds.map((data) => (
                        <tr key={data.id}>
                            <th className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {data.id}
                            </th>
                            <td className="px-6 py-4">{data.status}</td>
                            <td className="px-6 py-4">{data.validate_only}</td>
                            <td className="px-6 py-4">{data.name}</td>
                            <td className="px-6 py-4">{data.customer_id}</td>
                            <td className="px-6 py-4">{data.gclid}</td>
                            <td className="px-6 py-4">
                                {data.conversion_action_id}
                            </td>
                            <td className="px-6 py-4">
                                {data.conversion_date_time}
                            </td>
                            <td className="px-6 py-4">
                                {data.conversion_value}
                            </td>
                            <td className="px-6 py-4">{data.order_id}</td>
                            <td className="px-6 py-4">
                                <button
                                    onClick={() => onEdit(data)}
                                    className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                >
                                    CVを調整
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}
