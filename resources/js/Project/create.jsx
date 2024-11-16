import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import { useForm } from "@inertiajs/react";
import React from "react";

export default function create() {
  const { data, setData, post, processing, errors, reset } = useForm({
    email: "",
  });

  return (
    <>
      <form>
        <div className="mb-3">
          <InputLabel htmlFor="exampleInputEmail1" className="form-label">
            Email address
          </InputLabel>
          <TextInput
            id="exampleInputEmail1"
            type="email"
            className="form-control"
            aria-describedby="emailHelp"
          />
        </div>
      </form>
    </>
  );
}
