<?php
 namespace Illuminate\Database\Query\Grammars; use Illuminate\Support\Arr; use Illuminate\Database\Query\Builder; use Illuminate\Database\Query\JoinClause; use Illuminate\Database\Grammar as BaseGrammar; class Grammar extends BaseGrammar { protected $operators = []; protected $selectComponents = [ 'aggregate', 'columns', 'from', 'joins', 'wheres', 'groups', 'havings', 'orders', 'limit', 'offset', 'unions', 'lock', ]; public function compileSelect(Builder $query) { $original = $query->columns; if (is_null($query->columns)) { $query->columns = ['*']; } $sql = trim($this->concatenate( $this->compileComponents($query)) ); $query->columns = $original; return $sql; } protected function compileComponents(Builder $query) { $sql = []; foreach ($this->selectComponents as $component) { if (! is_null($query->$component)) { $method = 'compile'.ucfirst($component); $sql[$component] = $this->$method($query, $query->$component); } } return $sql; } protected function compileAggregate(Builder $query, $aggregate) { $column = $this->columnize($aggregate['columns']); if ($query->distinct && $column !== '*') { $column = 'distinct '.$column; } return 'select '.$aggregate['function'].'('.$column.') as aggregate'; } protected function compileColumns(Builder $query, $columns) { if (! is_null($query->aggregate)) { return; } $select = $query->distinct ? 'select distinct ' : 'select '; return $select.$this->columnize($columns); } protected function compileFrom(Builder $query, $table) { return 'from '.$this->wrapTable($table); } protected function compileJoins(Builder $query, $joins) { return collect($joins)->map(function ($join) { $table = $this->wrapTable($join->table); return trim("{$join->type} join {$table} {$this->compileWheres($join)}"); })->implode(' '); } protected function compileWheres(Builder $query) { if (is_null($query->wheres)) { return ''; } if (count($sql = $this->compileWheresToArray($query)) > 0) { return $this->concatenateWhereClauses($query, $sql); } return ''; } protected function compileWheresToArray($query) { return collect($query->wheres)->map(function ($where) use ($query) { return $where['boolean'].' '.$this->{"where{$where['type']}"}($query, $where); })->all(); } protected function concatenateWhereClauses($query, $sql) { $conjunction = $query instanceof JoinClause ? 'on' : 'where'; return $conjunction.' '.$this->removeLeadingBoolean(implode(' ', $sql)); } protected function whereRaw(Builder $query, $where) { return $where['sql']; } protected function whereBasic(Builder $query, $where) { $value = $this->parameter($where['value']); return $this->wrap($where['column']).' '.$where['operator'].' '.$value; } protected function whereIn(Builder $query, $where) { if (! empty($where['values'])) { return $this->wrap($where['column']).' in ('.$this->parameterize($where['values']).')'; } return '0 = 1'; } protected function whereNotIn(Builder $query, $where) { if (! empty($where['values'])) { return $this->wrap($where['column']).' not in ('.$this->parameterize($where['values']).')'; } return '1 = 1'; } protected function whereInSub(Builder $query, $where) { return $this->wrap($where['column']).' in ('.$this->compileSelect($where['query']).')'; } protected function whereNotInSub(Builder $query, $where) { return $this->wrap($where['column']).' not in ('.$this->compileSelect($where['query']).')'; } protected function whereNull(Builder $query, $where) { return $this->wrap($where['column']).' is null'; } protected function whereNotNull(Builder $query, $where) { return $this->wrap($where['column']).' is not null'; } protected function whereBetween(Builder $query, $where) { $between = $where['not'] ? 'not between' : 'between'; return $this->wrap($where['column']).' '.$between.' ? and ?'; } protected function whereDate(Builder $query, $where) { return $this->dateBasedWhere('date', $query, $where); } protected function whereTime(Builder $query, $where) { return $this->dateBasedWhere('time', $query, $where); } protected function whereDay(Builder $query, $where) { return $this->dateBasedWhere('day', $query, $where); } protected function whereMonth(Builder $query, $where) { return $this->dateBasedWhere('month', $query, $where); } protected function whereYear(Builder $query, $where) { return $this->dateBasedWhere('year', $query, $where); } protected function dateBasedWhere($type, Builder $query, $where) { $value = $this->parameter($where['value']); return $type.'('.$this->wrap($where['column']).') '.$where['operator'].' '.$value; } protected function whereColumn(Builder $query, $where) { return $this->wrap($where['first']).' '.$where['operator'].' '.$this->wrap($where['second']); } protected function whereNested(Builder $query, $where) { $offset = $query instanceof JoinClause ? 3 : 6; return '('.substr($this->compileWheres($where['query']), $offset).')'; } protected function whereSub(Builder $query, $where) { $select = $this->compileSelect($where['query']); return $this->wrap($where['column']).' '.$where['operator']." ($select)"; } protected function whereExists(Builder $query, $where) { return 'exists ('.$this->compileSelect($where['query']).')'; } protected function whereNotExists(Builder $query, $where) { return 'not exists ('.$this->compileSelect($where['query']).')'; } protected function compileGroups(Builder $query, $groups) { return 'group by '.$this->columnize($groups); } protected function compileHavings(Builder $query, $havings) { $sql = implode(' ', array_map([$this, 'compileHaving'], $havings)); return 'having '.$this->removeLeadingBoolean($sql); } protected function compileHaving(array $having) { if ($having['type'] === 'Raw') { return $having['boolean'].' '.$having['sql']; } return $this->compileBasicHaving($having); } protected function compileBasicHaving($having) { $column = $this->wrap($having['column']); $parameter = $this->parameter($having['value']); return $having['boolean'].' '.$column.' '.$having['operator'].' '.$parameter; } protected function compileOrders(Builder $query, $orders) { if (! empty($orders)) { return 'order by '.implode(', ', $this->compileOrdersToArray($query, $orders)); } return ''; } protected function compileOrdersToArray(Builder $query, $orders) { return array_map(function ($order) { return ! isset($order['sql']) ? $this->wrap($order['column']).' '.$order['direction'] : $order['sql']; }, $orders); } public function compileRandom($seed) { return 'RANDOM()'; } protected function compileLimit(Builder $query, $limit) { return 'limit '.(int) $limit; } protected function compileOffset(Builder $query, $offset) { return 'offset '.(int) $offset; } protected function compileUnions(Builder $query) { $sql = ''; foreach ($query->unions as $union) { $sql .= $this->compileUnion($union); } if (! empty($query->unionOrders)) { $sql .= ' '.$this->compileOrders($query, $query->unionOrders); } if (isset($query->unionLimit)) { $sql .= ' '.$this->compileLimit($query, $query->unionLimit); } if (isset($query->unionOffset)) { $sql .= ' '.$this->compileOffset($query, $query->unionOffset); } return ltrim($sql); } protected function compileUnion(array $union) { $conjuction = $union['all'] ? ' union all ' : ' union '; return $conjuction.$union['query']->toSql(); } public function compileExists(Builder $query) { $select = $this->compileSelect($query); return "select exists({$select}) as {$this->wrap('exists')}"; } public function compileInsert(Builder $query, array $values) { $table = $this->wrapTable($query->from); if (! is_array(reset($values))) { $values = [$values]; } $columns = $this->columnize(array_keys(reset($values))); $parameters = collect($values)->map(function ($record) { return '('.$this->parameterize($record).')'; })->implode(', '); return "insert into $table ($columns) values $parameters"; } public function compileInsertGetId(Builder $query, $values, $sequence) { return $this->compileInsert($query, $values); } public function compileUpdate(Builder $query, $values) { $table = $this->wrapTable($query->from); $columns = collect($values)->map(function ($value, $key) { return $this->wrap($key).' = '.$this->parameter($value); })->implode(', '); $joins = ''; if (isset($query->joins)) { $joins = ' '.$this->compileJoins($query, $query->joins); } $wheres = $this->compileWheres($query); return trim("update {$table}{$joins} set $columns $wheres"); } public function prepareBindingsForUpdate(array $bindings, array $values) { $cleanBindings = Arr::except($bindings, ['join', 'select']); return array_values( array_merge($bindings['join'], $values, Arr::flatten($cleanBindings)) ); } public function compileDelete(Builder $query) { $wheres = is_array($query->wheres) ? $this->compileWheres($query) : ''; return trim("delete from {$this->wrapTable($query->from)} $wheres"); } public function prepareBindingsForDelete(array $bindings) { return Arr::flatten($bindings); } public function compileTruncate(Builder $query) { return ['truncate '.$this->wrapTable($query->from) => []]; } protected function compileLock(Builder $query, $value) { return is_string($value) ? $value : ''; } public function supportsSavepoints() { return true; } public function compileSavepoint($name) { return 'SAVEPOINT '.$name; } public function compileSavepointRollBack($name) { return 'ROLLBACK TO SAVEPOINT '.$name; } protected function concatenate($segments) { return implode(' ', array_filter($segments, function ($value) { return (string) $value !== ''; })); } protected function removeLeadingBoolean($value) { return preg_replace('/and |or /i', '', $value, 1); } public function getOperators() { return $this->operators; } } 