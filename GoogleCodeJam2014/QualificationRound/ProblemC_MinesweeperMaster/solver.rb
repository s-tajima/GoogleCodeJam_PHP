require 'pp'

def read_input(file)
  File.open(file)
end

def make_test_case(input)
  test_cases = Array.new

  test_case_num = input.gets.strip
  test_case_num.to_i.times do |case_num|
    test_case = Hash.new

    test_case = Hash[*[['R', 'C', 'M'], input.gets.strip.split.map {|i| i.to_i }].transpose.flatten]

    test_cases << test_case
  end
  test_cases
end

def solver(test_case)
  field = Array.new(test_case['R']).map { Array.new(test_case['C'], '.') }

  replace_list = make_replace_list(test_case['R'], test_case['C'])

  test_case['M'].times do 
    replace_r, replace_c = replace_list.shift
    field[replace_r][replace_c] = '*'
  end
  field.map{|f|f.join}.join("\n")
  click = search_clickable_cell(field)

  return 'Impossible' unless click

  field[click[0]][click[1]] = 'c'
  field.map{|f| f.join}.join("\n")
end

def make_replace_list(row, column)
  center_r = row / 2
  center_c = column / 2

  replace_list = Array.new
  cells = Array.new
  row.times do |r|
    column.times do |c|
      cell = Hash.new
      cell['distance'] = (center_r - r) ** 2 + (center_c - c) ** 2
      cell['pos'] = [r, c]
      cells << cell
    end
  end
  cells.sort_by {|cell| cell['distance']}.reverse.map {|cell| cell['pos']}
end

def search_clickable_cell(field)
  field.each_with_index do |row, r_num|
    row.each_with_index do |column, c_num|
      next if field[r_num][c_num] == '*'

      next if (r_num - 1 >= 0 || c_num - 1 >= 0) && !field[r_num + 1].nil? && !field[r_num + 1][c_num + 1].nil? && field[r_num + 1][c_num + 1] == "*" 
      next if (r_num - 1 >= 0 || c_num - 1 >= 0) && !field[r_num - 1].nil? && !field[r_num - 1][c_num - 1].nil? && field[r_num - 1][c_num - 1] == "*"
      next if (r_num - 1 >= 0 || c_num - 1 >= 0) && !field[r_num + 1].nil? && !field[r_num + 1][c_num - 1].nil? && field[r_num + 1][c_num - 1] == "*"
      next if (r_num - 1 >= 0 || c_num - 1 >= 0) && !field[r_num - 1].nil? && !field[r_num - 1][c_num + 1].nil? && field[r_num - 1][c_num + 1] == "*"
      next if (r_num - 1 >= 0 || c_num - 1 >= 0) && !field[r_num    ].nil? && !field[r_num    ][c_num + 1].nil? && field[r_num    ][c_num + 1] == "*"
      next if (r_num - 1 >= 0 || c_num - 1 >= 0) && !field[r_num    ].nil? && !field[r_num    ][c_num - 1].nil? && field[r_num    ][c_num - 1] == "*"
      next if (r_num - 1 >= 0 || c_num - 1 >= 0) && !field[r_num + 1].nil? && !field[r_num + 1][c_num    ].nil? && field[r_num + 1][c_num    ] == "*"
      next if (r_num - 1 >= 0 || c_num - 1 >= 0) && !field[r_num - 1].nil? && !field[r_num - 1][c_num    ].nil? && field[r_num - 1][c_num    ] == "*"

      return [r_num, c_num]
    end
  end
  return false
end

input_file = ARGV.shift
input_file = 'sample-attempt.in' if input_file.nil?
input      = read_input(input_file)

test_cases = make_test_case(input)
#puts solver test_cases[2]

test_cases.each_with_index do |test_case, num|
   puts "Case ##{num + 1}:\n#{solver test_case}"
end


