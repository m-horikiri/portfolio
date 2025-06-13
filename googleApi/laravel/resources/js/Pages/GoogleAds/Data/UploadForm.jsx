import React, { useMemo, useState, useEffect } from "react";
import { router } from "@inertiajs/react";
import { v4 as uuidv4, validate } from "uuid";

export default function UploadForm({ editData, onClose }) {
    const order_id = useMemo(() => uuidv4(), []);

    const [apiData, setApiData] = useState({
        name: "",
        media: "",
        gclid: "",
        conversion_time: "",
        conversion_value: "",
        conversion_action_id: "*****",
        order_id: order_id,
        validate_only: 1,
    });

    // editDataが変更されたらapiDataを更新
    useEffect(() => {
        if (editData) {
            setApiData((prev) => ({
                ...prev,
                name: editData.name || "",
                media: editData.media || "",
                gclid: editData.gclid || "",
            }));
        }
    }, [editData]);

    function handleChange(e) {
        const key = e.target.name;
        const value = e.target.value;
        setApiData((prev) => ({
            ...prev,
            [key]: value,
        }));
    }

    function conversionSubmit(e) {
        e.preventDefault();
        router.post("/sendApi/upload", apiData);
    }

    if (!editData) return null;
    return (
        <div className="overflow-y-auto overflow-x-hidden fixed inset-0 z-50 justify-center items-center w-1/2 h-1/2 m-auto p-4 bg-indigo-700 rounded-lg shadow-sm">
            <button
                onClick={onClose}
                className="block ml-auto mb-5 focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
            >
                CLOSE
            </button>
            <form onSubmit={conversionSubmit}>
                <label className="mb-5 flex justify-around items-center">
                    <span className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        conversion_time
                    </span>
                    <input
                        name="conversion_time"
                        value={apiData.conversion_time}
                        pattern="\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}[\+\-]\d{2}:\d{2}"
                        required={true}
                        onChange={handleChange}
                        className="w-3/4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    />
                </label>
                <label className="mb-5 flex justify-around items-center">
                    <span className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        conversion_value
                    </span>
                    <input
                        name="conversion_value"
                        value={apiData.conversion_value}
                        type="number"
                        required={true}
                        onChange={handleChange}
                        className="w-3/4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    />
                </label>
                <label className="mb-5 flex justify-around items-center">
                    <span className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        conversion_action_id
                    </span>
                    <select
                        name="conversion_action_id"
                        value={apiData.conversion_action_id}
                        required={true}
                        onChange={handleChange}
                        className="w-3/4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    >
                        <option value="*****">*****</option>
                        <option value="*****">**</option>
                        <option value="*****">***</option>
                        <option value="*****">****</option>
                    </select>
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
                    className="block mx-auto my-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                >
                    コンバージョンのアップロード
                </button>
            </form>
        </div>
    );
}
