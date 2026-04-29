import { useMutation, useQueryClient } from "@tanstack/react-query";
import { Form, Formik } from "formik";
import React from "react";
import { FaTimes } from "react-icons/fa";
import * as Yup from "yup";
import { queryData } from "../../../../../functions/custom-hooks/queryData";
import { apiVersion } from "../../../../../functions/functions-general";
import useQueryData from "../../../../../functions/custom-hooks/useQueryData";
import {
  setError,
  setIsAdd,
  setMessage,
  setSuccess,
} from "../../../../../store/StoreAction";
import { StoreContext } from "../../../../../store/StoreContext";
import ModalWrapperSide from "../../../../../partials/modals/ModalWrapperSide";
import MessageError from "../../../../../partials/MessageError";
import ButtonSpinner from "../../../../../partials/spinners/ButtonSpinner";
import { InputSelect, InputText } from "../../../../../components/form-input/FormInputs";

const ModalAddSystemUsers = ({ itemEdit }) => {
  const { store, dispatch } = React.useContext(StoreContext);

  const { data: rolesData } = useQueryData(
    `${apiVersion}/controllers/developers/settings/roles/roles.php`,
    "get",
    "roles-options",
  );

  const queryClient = useQueryClient();
  const mutation = useMutation({
    mutationFn: (values) =>
      queryData(
        itemEdit
          ? `${apiVersion}/controllers/developers/settings/system-users/system-users.php?id=${itemEdit.system_users_aid}`
          : `${apiVersion}/controllers/developers/settings/system-users/system-users.php`,
        itemEdit ? "put" : "post",
        values,
      ),
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: ["system-users"] });

      if (data.success) {
        dispatch(setSuccess(true));
        dispatch(setMessage(`Successfully ${itemEdit ? "updated" : "added"}`));
        dispatch(setIsAdd(false));
      }
      if (data.success == false) {
        dispatch(setError(true));
        dispatch(setMessage(data.error));
      }
    },
  });

  const initVal = {
    system_users_first_name: itemEdit ? itemEdit.system_users_first_name : "",
    system_users_last_name: itemEdit ? itemEdit.system_users_last_name : "",
    system_users_email: itemEdit ? itemEdit.system_users_email : "",
    system_users_role_id: itemEdit ? itemEdit.system_users_role_id : "",
    system_users_email_old: itemEdit ? itemEdit.system_users_email : "",
  };

  const yupSchema = Yup.object({
    system_users_first_name: Yup.string().trim().required("required"),
    system_users_last_name: Yup.string().trim().required("required"),
    system_users_email: Yup.string().trim().email("invalid email").required("required"),
    system_users_role_id: Yup.string().trim().required("required"),
  });

  const handleClose = () => {
    dispatch(setIsAdd(false));
  };

  React.useEffect(() => {
    dispatch(setError(false));
  }, []);

  return (
    <>
      <ModalWrapperSide
        handleClose={handleClose}
        className="transition-all ease-in-out transform duration-200"
      >
        <div className="modal-header relative mb-4">
          <h3 className="text-dark text-sm">
            {itemEdit ? "Update" : "Add"} System User
          </h3>
          <button
            type="button"
            className="absolute top-0 right-4"
            onClick={handleClose}
          >
            <FaTimes />
          </button>
        </div>

        <div className="modal-body">
          <Formik
            initialValues={initVal}
            validationSchema={yupSchema}
            onSubmit={async (values) => {
              dispatch(setError(false));
              mutation.mutate(values);
            }}
          >
            {(props) => {
              return (
                <Form className="h-full">
                  <div className="modal-form-container">
                    <div className="modal-container">
                      <div className="relative mb-6">
                        <InputText
                          label="First Name"
                          name="system_users_first_name"
                          type="text"
                          disabled={mutation.isPending}
                        />
                      </div>

                      <div className="relative mb-6">
                        <InputText
                          label="Last Name"
                          name="system_users_last_name"
                          type="text"
                          disabled={mutation.isPending}
                        />
                      </div>

                      <div className="relative mb-6">
                        <InputText
                          label="Email"
                          name="system_users_email"
                          type="email"
                          disabled={mutation.isPending}
                        />
                      </div>

                      <div className="relative mb-6">
                        <InputSelect
                          label="Role"
                          name="system_users_role_id"
                          disabled={mutation.isPending}
                        >
                          <option value=""></option>
                          {rolesData?.data
                            ?.filter((role) => Number(role.role_is_active) === 1)
                            ?.map((role) => (
                              <option key={role.role_aid} value={role.role_aid}>
                                {role.role_name}
                              </option>
                            ))}
                        </InputSelect>
                      </div>

                      {store.error && <MessageError />}
                    </div>

                    <div className="modal-action">
                      <button
                        type="submit"
                        disabled={mutation.isPending || !props.dirty}
                        className="btn-modal-submit"
                      >
                        {mutation.isPending ? (
                          <ButtonSpinner />
                        ) : itemEdit ? (
                          "Save"
                        ) : (
                          "Add"
                        )}
                      </button>
                      <button
                        type="reset"
                        className="btn-modal-cancel"
                        onClick={handleClose}
                        disabled={mutation.isPending}
                      >
                        Cancel
                      </button>
                    </div>
                  </div>
                </Form>
              );
            }}
          </Formik>
        </div>
      </ModalWrapperSide>
    </>
  );
};

export default ModalAddSystemUsers;
