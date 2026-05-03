import { useMutation, useQueryClient } from "@tanstack/react-query";
import { Form, Formik } from "formik";
import React from "react";
import { FaTimes } from "react-icons/fa";
import * as Yup from "yup";
import { queryData } from "../../../../functions/custom-hooks/queryData";
import { apiVersion } from "../../../../functions/functions-general";
import useQueryData from "../../../../functions/custom-hooks/useQueryData";
import {
  setError,
  setIsAdd,
  setMessage,
  setSuccess,
} from "../../../../store/StoreAction";
import { StoreContext } from "../../../../store/StoreContext";
import ModalWrapperSide from "../../../../partials/modals/ModalWrapperSide";
import MessageError from "../../../../partials/MessageError";
import ButtonSpinner from "../../../../partials/spinners/ButtonSpinner";
import { InputSelect, InputText } from "../../../../components/form-input/FormInputs";

const ModalAddDesignation = ({ itemEdit }) => {
  const { store, dispatch } = React.useContext(StoreContext);

  const { data: categoryData } = useQueryData(
    `${apiVersion}/controllers/developers/settings/category/category.php`,
    "get",
    "designation-category-options",
  );

  const queryClient = useQueryClient();
  const mutation = useMutation({
    mutationFn: (values) =>
      queryData(
        itemEdit
          ? `${apiVersion}/controllers/developers/settings/designation/designation.php?id=${itemEdit.designation_aid}`
          : `${apiVersion}/controllers/developers/settings/designation/designation.php`,
        itemEdit ? "put" : "post",
        values,
      ),
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: ["designation"] });

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
    designation_name: itemEdit ? itemEdit.designation_name : "",
    designation_category_id: itemEdit ? itemEdit.designation_category_id : "",
    designation_name_old: itemEdit ? itemEdit.designation_name : "",
  };

  const yupSchema = Yup.object({
    designation_name: Yup.string().trim().required("required"),
    designation_category_id: Yup.string().trim().required("required"),
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
            {itemEdit ? "Update" : "Add"} Designation
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
                          label="Designation Name"
                          name="designation_name"
                          type="text"
                          disabled={mutation.isPending}
                        />
                      </div>

                      <div className="relative mb-6">
                        <InputSelect
                          label="Category"
                          name="designation_category_id"
                          disabled={mutation.isPending}
                        >
                          <option value=""></option>
                          {categoryData?.data
                            ?.filter((category) => Number(category.category_is_active) === 1)
                            ?.map((category) => (
                              <option key={category.category_aid} value={category.category_aid}>
                                {category.category_name}
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

export default ModalAddDesignation;
