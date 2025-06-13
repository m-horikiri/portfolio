import React, { useState } from "react";
import { usePage } from "@inertiajs/react";
import DataTable from "./DataTable";
import AdjustmentForm from "./AdjustmentForm";

export default function Index() {
    const { uploadeds, flash } = usePage().props;
    const [editData, setEditData] = useState(null);
    console.log(flash.response);
    return (
        <div className="container mx-auto p-8 bg-gray-900 relative">
            <h1 className="mb-5 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-3xl lg:text-4xl dark:text-white">
                アップロード済みコンバージョン 🪄
            </h1>
            {flash.response && (
                <ul>
                {Object.entries(flash.response).map(([key, value]) => (
                    <li key={key}>
                        {key}: {value}
                    </li>
                ))}
                </ul>
            )}
            <DataTable uploadeds={uploadeds} onEdit={setEditData} />
            <AdjustmentForm
                editData={editData}
                onClose={() => setEditData(null)}
            />
        </div>
    );
}
