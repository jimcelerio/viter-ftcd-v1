import { useMutation, useQueryClient } from "@tanstack/react-query";
import { Form, Formik } from "formik";
import React from "react";
import { FaTimes } from "react-icons/fa";
import * as Yup from "yup";
import { queryData } from "../../../functions/custom-hooks/queryData";
import { apiVersion } from "../../../functions/functions-general";
import {
  setError,
  setIsAdd,
  setMessage,
  setSuccess,
} from "../../../store/StoreAction";
import { StoreContext } from "../../../store/StoreContext";
import ModalWrapperSide from "../../../partials/modals/ModalWrapperSide";
import MessageError from "../../../partials/MessageError";
import ButtonSpinner from "../../../partials/spinners/ButtonSpinner";
import {
  InputCheckbox,
  InputText,
  InputTextArea,
} from "../../../components/form-input/FormInputs";

const ModalAddChildren = ({ itemEdit }) => {
  const { store, dispatch } = React.useContext(StoreContext);

  const queryClient = useQueryClient();
  const mutation = useMutation({
    mutationFn: (values) =>
      queryData(
        itemEdit
          ? `${apiVersion}/controllers/developers/children/children.php?id=${itemEdit.children_aid}`
          : `${apiVersion}/controllers/developers/children/children.php`,
        itemEdit ? "put" : "post",
        values,
      ),
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: ["children"] });

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
    children_name: itemEdit ? itemEdit.children_name : "",
    children_birth_date: itemEdit ? itemEdit.children_birth_date : "",
    children_story: itemEdit ? itemEdit.children_story : "",
    children_donation_limit: itemEdit ? itemEdit.children_donation_limit : "0.00",
    is_resident: itemEdit ? itemEdit.children_residency === "Resident" : false,
    children_name_old: itemEdit ? itemEdit.children_name : "",
  };

  const yupSchema = Yup.object({
    children_name: Yup.string().trim().required("required"),
    children_birth_date: Yup.string().trim().required("required"),
    children_story: Yup.string().trim().required("required"),
    children_donation_limit: Yup.number().typeError("required").min(0).required("required"),
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
            {itemEdit ? "Update" : "Add"} Children
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
              mutation.mutate({
                ...values,
                children_residency: values.is_resident ? "Resident" : "Non-Resident",
              });
            }}
          >
            {(props) => {
              return (
                <Form className="h-full">
                  <div className="modal-form-container">
                    <div className="modal-container">
                      <div className="relative mb-6">
                        <InputText
                          label="Full Name"
                          name="children_name"
                          type="text"
                          disabled={mutation.isPending}
                        />
                      </div>

                      <div className="relative mb-6">
                        <InputText
                          label="Birth Date"
                          name="children_birth_date"
                          type="date"
                          disabled={mutation.isPending}
                        />
                      </div>

                      <div className="relative mb-6">
                        <InputTextArea
                          label="My Story"
                          name="children_story"
                          disabled={mutation.isPending}
                        />
                      </div>

                      <div className="relative mb-6">
                        <InputText
                          label="Donation Amount Limit"
                          name="children_donation_limit"
                          type="text"
                          disabled={mutation.isPending}
                        />
                      </div>

                      <div className="mb-6">
                        <InputCheckbox
                          label="Mark Check If Resident"
                          name="is_resident"
                          disabled={mutation.isPending}
                        />
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

export default ModalAddChildren;
