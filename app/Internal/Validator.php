<?php

namespace App\Internal;

class Validator
{
    protected array $errors = [];

    /**
     * @param SQLRepository $repository 
     * 
     * @return void 
     */
    public function __construct(
        protected readonly Repository $repository,
    )
    {        
    }

    /**
     * @param Model $model 
     * 
     * @return bool 
     */
    public function validate(Model $model): bool
    {
        foreach ($model->rules() as $attribute => $rules) {
            $value = $model->{$attribute};

            foreach ($rules as $rule) {
                $_rule = (! is_string($rule)) ? $rule : $rule[0];

                if ($_rule === Rule::REQUIRED && ! $value) {
                    $this->error($attribute, Rule::REQUIRED);
                }

                if ($_rule === Rule::MIN && strlen($value) < $rule['min']) {
                    $this->error($attribute, Rule::MIN, $rule);
                }

                if ($_rule === Rule::MAX && strlen($value) > $rule['max']) {
                    $this->error($attribute, Rule::MAX, $rule);
                }

                if ($_rule === Rule::MATCH && $value !== $model->{$rule['match']}) {
                    $rule['match'] = $model->labels()[$rule['match']] ?? $rule['match'];
                    $this->error($attribute, Rule::MATCH, $rule);
                }

                if ($_rule === Rule::UNIQUE) {
                    [$table, $unique] = [$rule['class']::table(), $rule['attribute'] ?? $attribute];
                    $query = sprintf("SELECT * FROM `%s` WHERE `%s.%s` = :unique", $table, $table, $unique);

                    if ($this->repository->select($query, ['unique' => $value], Repository::FETCH_ALL)) {
                        $this->error($attribute, Rule::UNIQUE, ['field' => $model->labels()[$attribute]]);
                    }
                } 
            }
        }

        return empty($this->errors);
    }

    /**
     * @param string $attribute 
     * @param Rule $rule 
     * @param array $params 
     * 
     * @return void 
     */
    public function error(string $attribute, Rule $rule, array $params = []): void
    {
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $rule->message());
        }

        $this->errors[$attribute][] = $message;
    }
}