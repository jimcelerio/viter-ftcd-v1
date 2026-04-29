import React from "react";
import { FaChevronRight, FaUserCircle } from "react-icons/fa";
import Layout from "../../Layout";
import { useNavigate } from "react-router-dom";
import { devNavUrl, urlDeveloper } from "../../../../functions/functions-general";

const userItems = [
  {
    label: "System user",
    path: `${devNavUrl}/${urlDeveloper}/settings/users/system-users`,
  },
  { label: "Other user" },
  { label: "Roles", path: `${devNavUrl}/${urlDeveloper}/settings/users/roles` },
];

const Users = () => {
  const navigate = useNavigate();

  return (
    <Layout menu="settings" submenu="users">
      <div className="mt-2">
        <h1 className="font-bold">Users</h1>
      </div>

      <div className="mt-4 border-t border-gray-300">
        {userItems.map((item) => {
          return (
            <button
              key={item.label}
              type="button"
              className="w-full flex items-center justify-between gap-3 py-4 border-b border-gray-300 hover:bg-gray-50 text-left"
              onClick={() => item.path && navigate(item.path)}
            >
              <div className="flex items-center gap-3">
                <FaUserCircle className="h-5 w-5" />
                <span className="font-semibold">{item.label}</span>
              </div>
              <FaChevronRight className="h-4 w-4" />
            </button>
          );
        })}
      </div>
    </Layout>
  );
};

export default Users;
