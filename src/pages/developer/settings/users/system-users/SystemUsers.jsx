import React from "react";
import Layout from "../../../Layout";
import { FaPlus } from "react-icons/fa";
import { StoreContext } from "../../../../../store/StoreContext";
import { setIsAdd } from "../../../../../store/StoreAction";
import SystemUsersList from "./SystemUsersList";
import ModalAddSystemUsers from "./ModalAddSystemUsers";

const SystemUsers = () => {
  const { store, dispatch } = React.useContext(StoreContext);
  const [itemEdit, setItemEdit] = React.useState(null);

  const handleAdd = () => {
    dispatch(setIsAdd(true));
    setItemEdit(null);
  };

  return (
    <>
      <Layout menu="settings" submenu="users">
        <div className="flex items-center justify-between w-full">
          <h1>System Users</h1>
          <div>
            <button
              type="button"
              className="flex items-center gap-1 hover:underline"
              onClick={handleAdd}
            >
              <FaPlus className="text-primary" />
              add
            </button>
          </div>
        </div>

        <div>
          <SystemUsersList itemEdit={itemEdit} setItemEdit={setItemEdit} />
        </div>
      </Layout>

      {store.isAdd && <ModalAddSystemUsers itemEdit={itemEdit} />}
    </>
  );
};

export default SystemUsers;
