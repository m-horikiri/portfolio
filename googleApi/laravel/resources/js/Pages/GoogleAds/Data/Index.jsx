import React, { useState } from "react";
import { usePage, router } from "@inertiajs/react";
import DataTable from "./DataTable";
import UploadForm from "./UploadForm";
import ActionsList from "./ActionsList";
import OfflineConversionUploaded from "./OfflineConversionUploaded";

function DataForm() {
    const [newData, setNewData] = useState({
        name: "",
        media: "",
        gclid: "",
        acceptanceTime: "",
    });

    function handleChange(e) {
        const key = e.target.name;
        const value = e.target.value;
        setNewData((newData) => ({
            ...newData,
            [key]: value,
        }));
    }

    function dataFormSubmit(e) {
        e.preventDefault();
        router.post("/data/add", newData);
    }

    return (
        <>
            <form onSubmit={dataFormSubmit}>
                <label className="mb-5 flex justify-around items-center">
                    <span className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        名前
                    </span>
                    <input
                        name="name"
                        value={newData.name}
                        onChange={handleChange}
                        className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-9/12 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    />
                </label>
                <label className="mb-5 flex justify-around items-center">
                    <span className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        媒体名
                    </span>
                    <input
                        name="media"
                        value={newData.media}
                        required={true}
                        onChange={handleChange}
                        className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-9/12 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    />
                </label>
                <label className="mb-5 flex justify-around items-center">
                    <span className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        GCLID
                    </span>
                    <input
                        name="gclid"
                        value={newData.gclid}
                        required={true}
                        onChange={handleChange}
                        className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-9/12 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    />
                </label>
                <label className="mb-5 flex justify-around items-center">
                    <span className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        受付日時
                    </span>
                    <input
                        name="acceptanceTime"
                        value={newData.acceptanceTime}
                        onChange={handleChange}
                        className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-9/12 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    />
                </label>
                <button
                    type="submit"
                    className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                >
                    登録
                </button>
            </form>
        </>
    );
}

export default function Index() {
    const { datas, conversionActions, offlineCvUploaded } = usePage().props;
    const [editData, setEditData] = useState(null);
    return (
        <div className="container mx-auto p-8 bg-gray-900 relative">
            <h1 className="mb-5 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-3xl lg:text-4xl dark:text-white">
                情報登録📝
            </h1>
            <DataForm />
            <DataTable datas={datas} onEdit={setEditData} />
            <UploadForm editData={editData} onClose={() => setEditData(null)} />
            <OfflineConversionUploaded offlineCvUploaded={offlineCvUploaded} />
            <ActionsList conversionActions={conversionActions} />
        </div>
    );
}
