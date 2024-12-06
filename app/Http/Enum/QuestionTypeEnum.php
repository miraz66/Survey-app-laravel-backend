<?php

namespace App\Http\Enum;

enum QuestionTypeEnum: string
{
  case TYPE_TEXT = 'text';
  case TYPE_DESCRIPTION = 'textarea';
  case TYPE_RADIO = 'radio';
  case TYPE_CHECKBOX = 'checkbox';
  case TYPE_SELECT = 'select';
  case TYPE_SELECT_MULTIPLE = 'select-multiple';
}
