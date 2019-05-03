<?

class Values
{

    private $values;

    public function Set($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function SetIfDoesntExist($key, $value)
    {
        if (!array_key_exists($key, $this->values)) {
            $this->Set($key, $value);
        }
    }

    public function AddMultiple($keyedArray)
    {
        throw new Exception("AddMultiple() not implimented");
    }

    public function Contains($key)
    {
        return array_key_exists($key, $this->values);
    }

    public function Get($key)
    {
        return $this->values[$key];
    }

    public function AssertKey($key)
    {
        if (!array_key_exists($key, $this->values)) {
            throw new Exception("requestValuues does not contain key: $key");
        }
    }

}
