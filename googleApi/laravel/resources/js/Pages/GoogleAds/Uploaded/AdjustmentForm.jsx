import React, { useState, useEffect } from "react";
import { router } from "@inertiajs/react";

export default function AdjustmentForm({ editData, onClose }) {
    const [adjustmentData, setAdjustmentData] = useState({
        customer_id: "",
        conversion_action_id: "",
        order_id: "",
        adjustment_type: "RESTATEMENT",
        restatement_value: "",
        adjustment_date_time: "",
        validate_only: 1,
    });

    // editDataが変更されたらapiDataを更新
    useEffect(() => {
        if (editData) {
            setAdjustmentData((prev) => ({
                ...prev,
                customer_id: editData.customer_id || "",
                conversion_action_id: editData.conversion_action_id || "",
                order_id: editData.order_id || "",
            }));
        }
    }, [editData]);

    const [restatement, setRestatement] = useState(true);

    function handleChange(e) {
        const key = e.target.name;
        const value = e.target.value;
        setAdjustmentData((prev) => ({
            ...prev,
            [key]: value,
        }));
    }

    function restatementChange(e) {
        if (e.target.value === "RESTATEMENT") {
            setRestatement(true);
            setAdjustmentData((prev) => ({
                ...prev,
                restatement_value: e.target.value,
            }));
        } else {
            setRestatement(false);
            setAdjustmentData((prev) => {
                const newData = { ...prev };
                delete newData.restatement_value;
                return newData;
            });
        }
    }

    function adjustmentSubmit(e) {
        e.preventDefault();
        router.post("/sendApi/adjustment", adjustmentData);
    }

    if (!editData) return null;

    return (
        <div className="overflow-y-auto overflow-x-hidden fixed inset-0 z-50 justify-center items-center w-1/2 h-3/4 m-auto p-4 bg-indigo-700 rounded-lg shadow-sm">
            <button
                onClick={onClose}
                className="block mb-5 ml-auto focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
            >
                CLOSE
            </button>
            <form onSubmit={adjustmentSubmit}>
                <div className="mb-5">
                    <div className="text-xl font-bold dark:text-white">
                        調整のタイプ
                    </div>
                    <label className="mb-5 flex justify-around items-center">
                        <span className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            値の変更
                        </span>
                        <input
                            name="adjustment_type"
                            value="RESTATEMENT"
                            type="radio"
                            checked={true}
                            onChange={restatementChange}
                            className="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600"
                        />
                    </label>
                    <label className="mb-5 flex justify-around items-center">
                        <span className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            コンバージョンの削除
                        </span>
                        <input
                            name="adjustment_type"
                            value="RETRACTION"
                            type="radio"
                            onChange={restatementChange}
                            className="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600"
                        />
                    </label>
                </div>
                {restatement && (
                    <label className="mb-5 flex justify-around items-center">
                        <span className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            修正後のコンバージョン値
                        </span>
                        <input
                            name="restatement_value"
                            value={adjustmentData.restatement_value}
                            type="number"
                            onChange={handleChange}
                            className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                    </label>
                )}
                <label className="mb-5 flex justify-around items-center">
                    <span className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        修正後のコンバージョン日時
                    </span>
                    <input
                        name="adjustment_date_time"
                        value={adjustmentData.adjustment_date_time}
                        pattern="\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}[\+\-]\d{2}:\d{2}"
                        required={true}
                        onChange={handleChange}
                        className="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    />
                </label>
                <div className="mb-5 w-3/4">
                    <div className="text-xl font-bold dark:text-white">
                        validate_only
                    </div>
                    <label className="mb-5 flex justify-around items-center">
                        <span className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            false
                        </span>
                        <input
                            name="validate_only"
                            value="0"
                            type="checkbox"
                            onChange={handleChange}
                            className="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600"
                        />
                    </label>
                </div>
                <button
                    type="submit"
                    className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                >
                    コンバージョンの修正
                </button>
            </form>
        </div>
    );
}
